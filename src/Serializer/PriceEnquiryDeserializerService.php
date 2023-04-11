<?php
declare(strict_types=1);

namespace App\Serializer;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Product;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class PriceEnquiryDeserializerService
{
    public function deserializerDTO(
        string  $jsonBody,
        Product $product,


    ): LowestPriceEnquiry
    {

        $encoders = [new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new GetSetMethodNormalizer(propertyTypeExtractor: new ReflectionExtractor())];
        $serializer = new Serializer($normalizers, $encoders);

        /** @var LowestPriceEnquiry $lowestPriceEnquiry */
        $lowestPriceEnquiry = $serializer->deserialize(
            $jsonBody,
            LowestPriceEnquiry::class,
            'json');

        $lowestPriceEnquiry->setProduct($product); //TODO: maybe let deserialize do his job?

        return $lowestPriceEnquiry;
    }
}
