<?php
declare(strict_types=1);

namespace App\FilterPrice\PromotionVariant;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;
use Exception;

class DateRangeSale implements PromotionVariantInterface
{

    /**
     * @param LowestPriceEnquiry $lowestPriceEnquiry
     * @param Promotion $promotion
     * @param int $quantity
     * @param float $price
     * @return float
     * @throws Exception
     */
    public function calculate(LowestPriceEnquiry $lowestPriceEnquiry, Promotion $promotion, int $quantity, float $price): float
    {
        // TODO: request date should be date current
        //$now = (new \DateTimeImmutable())->setTime(0,0,0);
        // check valid date
        $dateRange = $promotion->getCriteria();
        $from = new \DateTimeImmutable($dateRange['from']);
        $to = new \DateTimeImmutable($dateRange['to']);

        $requestDate = new \DateTimeImmutable($lowestPriceEnquiry->getRequestDate());

        if($requestDate >= $from && $requestDate <= $to ){
            return $price * $quantity * $promotion->getAdjustment();
        }

        return $price * $quantity;
    }
}
