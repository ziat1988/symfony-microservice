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
        $product = $lowestPriceEnquiry->getProduct();
        $priceOriginal = (float)($product->getPrice());
        $quantity = $lowestPriceEnquiry->getQuantity();
        $priceTotal = $priceOriginal * $quantity;

        $lowestPriceEnquiry->setOriginalPrice($priceOriginal);
        foreach ($promotions as $promo){
            $priceByPromo = PromotionFactory::createPromotion($promo->getType());
            $priceAfterPromo = $priceByPromo->calculate($lowestPriceEnquiry,$promo,$quantity,$priceOriginal);

            if($priceAfterPromo <  $priceTotal){
                $lowestPriceEnquiry->setPromotionName($promo->getName());
                $lowestPriceEnquiry->setPromotionId($promo->getId());
                $lowestPriceEnquiry->setDiscountedPrice($priceAfterPromo);

                $priceTotal = $priceAfterPromo;
            }

        }

        $lowestPriceEnquiry->setTotalOriginalPrice($priceOriginal * $quantity);

        return $lowestPriceEnquiry;

    }

}
