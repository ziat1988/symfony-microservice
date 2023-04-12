<?php

namespace App\Controller;

use App\Cache\PromotionByProductCache;
use App\DTO\LowestPriceEnquiry;
use App\Event\DeserializerPriceEnquiryEvent;
use App\FilterPrice\LowestPriceFilter;
use App\Repository\ProductRepository;
use App\Serializer\PriceEnquiryDeserializerService;
use Exception;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ProductsController extends AbstractController
{

    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly LowestPriceFilter $lowestPriceFilter,
        private readonly PromotionByProductCache $cachePromotion,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly PriceEnquiryDeserializerService $priceEnquiryDeserializerService
    ){}


    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    #[Route('/products/{id}/lowest-price', name: 'products_lowest_price', methods: "POST")]
    public function lowestPrice(Request $request,int $id): JsonResponse
    {
        $product = $this->productRepository->find($id);

        if(!$product){
            throw new BadRequestHttpException('Not found product !',null,Response::HTTP_BAD_REQUEST);
        }

        $jsonBody = $request->getContent();
        $lowestPriceEnquiry = $this->priceEnquiryDeserializerService->deserializerDTO($jsonBody,$product);

        $event = new DeserializerPriceEnquiryEvent($lowestPriceEnquiry);
        $this->eventDispatcher->dispatch($event,DeserializerPriceEnquiryEvent::NAME);

        $promotions = $this->cachePromotion->findPromotionForProduct($product);
        $modifiedEnquiry = $this->lowestPriceFilter->apply($lowestPriceEnquiry,$promotions);

        return $this->json(data:$modifiedEnquiry,status:Response::HTTP_OK,context: [AbstractNormalizer::ATTRIBUTES=>
            [
                'quantity',
                'requestLocation',
                'voucherCode',
                'originalPrice',
                'discountedPrice',
                'promotionId',
                'promotionName',
                'product'=>['id']
            ]

        ]);

    }

}
