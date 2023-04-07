<?php
declare(strict_types=1);

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;
use App\FilterPrice\PromotionVariant\EvenItemsSale;
use App\Tests\ApplicationTestCase;

class PromotionPriceCalculateTest extends ApplicationTestCase
{
    /**
     * @dataProvider ProvideEnquiry
     */
    public function testEvenItemSale($price, $quantity, $priceExpected){

        $promotion = new Promotion();
        $promotion->setAdjustment(0.5);
        $promotion->setName('buy one get half');


        $lowestPriceEnquiry = new LowestPriceEnquiry();
        $lowestPriceEnquiry->setQuantity($quantity);


        $servicePromotion = new EvenItemsSale();
        $pricePromo = $servicePromotion->calculate($lowestPriceEnquiry,$promotion,$quantity,$price);

        self::assertSame($priceExpected,$pricePromo);

    }


    public function ProvideEnquiry(): \Generator
    {
        $price = floatval(100);
        yield [$price,5,floatval(400)];
        yield [$price,3,floatval(250)];
        yield[$price,2,floatval(150) ];
        yield[$price,1,floatval(100) ];

    }
}
