<?php
declare(strict_types=1);

namespace App\FilterPrice;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;
use App\FilterPrice\Factory\PromotionFactory;

class LowestPriceFilter
{
    /**
     * @param LowestPriceEnquiry $lowestPriceEnquiry
     * @param Promotion[] $promotions
     * @return LowestPriceEnquiry
     */
    public function apply(LowestPriceEnquiry $lowestPriceEnquiry, array $promotions): LowestPriceEnquiry
    {
        // loop every promotion on object
        $priceTotal = $lowestPriceEnquiry->getPrice() * $lowestPriceEnquiry->getQuantity();

        foreach ($promotions as $promo){
            $priceByPromo = PromotionFactory::createPromotion($promo->getType());
            $priceAfterPromo = $priceByPromo->calculate($lowestPriceEnquiry,$promo);

            if($priceAfterPromo <  $priceTotal){
                $priceTotal = $priceAfterPromo;
                $lowestPriceEnquiry->setPromotionName($promo->getName());
                $lowestPriceEnquiry->setPromotionId($promo->getId());
            }

        }
        $lowestPriceEnquiry->setFinalTotalPrice($priceTotal);

        return $lowestPriceEnquiry;

    }

}
