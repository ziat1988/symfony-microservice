<?php
declare(strict_types=1);

namespace App\FilterPrice\Factory;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;

class DateRangeSale implements PromotionVariantInterface
{

    /**
     * @throws \Exception
     */
    public function calculate(LowestPriceEnquiry $lowestPriceEnquiry, Promotion $promotion): float
    {
        // TODO: request date should be date current
        //$now = (new \DateTimeImmutable())->setTime(0,0,0);
        // check valid date
        $dateRange = $promotion->getCriteria();
        $from = new \DateTimeImmutable($dateRange['from']);
        $to = new \DateTimeImmutable($dateRange['to']);

        $requestDate = new \DateTimeImmutable($lowestPriceEnquiry->getRequestDate());

        $product = $lowestPriceEnquiry->getProduct();
        if($requestDate >= $from && $requestDate <= $to ){
            return $product->getPrice() * $lowestPriceEnquiry->getQuantity() * $promotion->getAdjustment();
        }

        return $product->getPrice() * $lowestPriceEnquiry->getQuantity();
    }
}
