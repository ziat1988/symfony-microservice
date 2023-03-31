<?php
declare(strict_types=1);

namespace App\FilterPrice\Factory;

class PromotionFactory
{
    public static function createPromotion(string $promotionType) : PromotionVariantInterface
    {
        return match ($promotionType) {
            'fixed_price_voucher' => new FixedPriceVoucher(),
            'date_range_multiplier' => new DateRangeSale(),
            default => throw new \RuntimeException('No type of promo found'),
        };

    }
}
