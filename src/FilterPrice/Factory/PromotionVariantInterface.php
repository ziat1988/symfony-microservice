<?php

namespace App\FilterPrice\Factory;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;

interface PromotionVariantInterface
{
    public function calculate(LowestPriceEnquiry $lowestPriceEnquiry, Promotion $promotion) :float;
}
