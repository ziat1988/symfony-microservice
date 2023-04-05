<?php
declare(strict_types=1);

namespace App\FilterPrice\Factory;

use App\FilterPrice\PromotionVariant\DateRangeSale;
use App\FilterPrice\PromotionVariant\EvenItemsSale;
use App\FilterPrice\PromotionVariant\FixedPriceVoucher;
use App\FilterPrice\PromotionVariant\PromotionVariantInterface;

class PromotionFactory
{
    public static function createPromotion(string $promotionType) : PromotionVariantInterface
    {
        return match ($promotionType) {
            'fixed_price_voucher' => new FixedPriceVoucher(),
            'date_range_multiplier' => new DateRangeSale(),
            'even_items_multiplier' => new EvenItemsSale(),
            default => throw new \RuntimeException('No type of promo found'),
        };

    }
}
