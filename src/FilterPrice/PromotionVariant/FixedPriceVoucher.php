<?php
declare(strict_types=1);

namespace App\FilterPrice\PromotionVariant;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;

class FixedPriceVoucher implements PromotionVariantInterface
{
    public function calculate(LowestPriceEnquiry $lowestPriceEnquiry, Promotion $promotion, int $quantity, float $price): float
    {
        // todo: refex schema database
        if($promotion->getAdjustment() < 10 ){
            throw new \RuntimeException('Not valid promotion');
        }
        // maybe need to store different way than json
        $codeCriteria = $promotion->getCriteria();

        if(isset($codeCriteria['code']) && $lowestPriceEnquiry->getVoucherCode() === $codeCriteria['code']){ // can be issu array key
            return $promotion->getAdjustment() * $quantity;
        }
        return $price * $quantity;
    }
}
