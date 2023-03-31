<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use App\FilterPrice\Factory\DateRangeSale;
use App\FilterPrice\LowestPriceFilter;
use App\Repository\ProductPromotionRepository;
use App\Repository\ProductRepository;
use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProductsController extends AbstractController
{

    public function __construct(
        private readonly ProductRepository $productRepository,
      //  private readonly ProductPromotionRepository $productPromotionRepository,
       private readonly PromotionRepository $promotionRepository,
       // private SerializerInterface $serializer
        private readonly DateRangeSale $dateRangeSale,
        private readonly LowestPriceFilter $lowestPriceFilter
    ){}


    /**
     * @throws \Exception
     */
    #[Route('/products/{id}/lowest-price', name: 'products_lowest_price', methods: "POST")]
    public function lowestPrice(Request $request,int $id): JsonResponse
    {
        $product = $this->productRepository->find($id);
        $jsonBody = $request->getContent();

        $encoders = [new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new GetSetMethodNormalizer(propertyTypeExtractor: new ReflectionExtractor())];
        $serializer = new Serializer($normalizers, $encoders);

        /** @var LowestPriceEnquiry $lowestPriceEnquiry */
        $lowestPriceEnquiry = $serializer->deserialize(
            $jsonBody,
            LowestPriceEnquiry::class,
            'json');


        $promotions = $this->promotionRepository->getPromotionByProduct($product);

        $this->lowestPriceFilter->apply($lowestPriceEnquiry,$promotions);






       // $price = $product->getPrice();

        //dd($this->json($serializer->serialize($lowestPriceEnquiry,'json')));
        return $this->json($serializer->serialize($lowestPriceEnquiry,'json'));
    }

    #[Route('/')]
    public function index()
    {
        dd('ok');
    }


}
