<?php
declare(strict_types=1);

namespace App\FilterPrice\Factory;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;

class FixedPriceVoucher implements PromotionVariantInterface
{
    public function calculate(LowestPriceEnquiry $lowestPriceEnquiry, Promotion $promotion): float
    {
        // maybe need to store different way than json
        $codeCriteria = $promotion->getCriteria();
        if($lowestPriceEnquiry->getVoucherCode() === $codeCriteria['code']){ // can be issu array key
            return $promotion->getAdjustment() * $lowestPriceEnquiry->getQuantity();

        }
        return $lowestPriceEnquiry->getPrice() * $lowestPriceEnquiry->getQuantity();
    }
}
