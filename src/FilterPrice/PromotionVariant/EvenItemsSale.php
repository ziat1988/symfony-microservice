<?php
declare(strict_types=1);

namespace App\FilterPrice\PromotionVariant;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;

class EvenItemsSale implements PromotionVariantInterface
{
    public function calculate(LowestPriceEnquiry $lowestPriceEnquiry, Promotion $promotion, int $quantity, float $price): float
    {
        // buy one price no change
        if($quantity < 2 ){
            return $price * $quantity;
        }

        // buy one, get one half (> 2 article)
        $oddCount = $quantity % 2; // 0 or 1
        $evenCount = $quantity - $oddCount;

        return ($evenCount/2*($price + $price * $promotion->getAdjustment())) + ($oddCount * $price);

    }
}
