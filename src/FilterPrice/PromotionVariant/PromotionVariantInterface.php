<?php

namespace App\FilterPrice\PromotionVariant;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;

interface PromotionVariantInterface
{
    public function calculate(LowestPriceEnquiry $lowestPriceEnquiry, Promotion $promotion,int $quantity, float $price) :float;
}
