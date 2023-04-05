<?php
declare(strict_types=1);

namespace App\FilterPrice\PromotionVariant;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;

class FixedPriceVoucher implements PromotionVariantInterface
{
    public function calculate(LowestPriceEnquiry $lowestPriceEnquiry, Promotion $promotion, int $quantity, float $price): float
    {
        // maybe need to store different way than json
        $codeCriteria = $promotion->getCriteria();

        if($lowestPriceEnquiry->getVoucherCode() === $codeCriteria['code']){ // can be issu array key
            return $promotion->getAdjustment() * $quantity;

        }
        return $price * $quantity;
    }
}
