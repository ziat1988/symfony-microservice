<?php
declare(strict_types=1);

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;
use App\FilterPrice\PromotionVariant\DateRangeSale;
use App\FilterPrice\PromotionVariant\EvenItemsSale;
use App\FilterPrice\PromotionVariant\FixedPriceVoucher;
use App\Tests\ApplicationTestCase;
use function Zenstruck\Foundry\anonymous;

class PromotionPriceCalculateTest extends ApplicationTestCase
{


    /**
     * @dataProvider ProvideEnquiryEven
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

    /**
     * @dataProvider ProvideDataDateRangeSale
     * @throws \Exception
     */
    public function testDateRangeSale(float $price,LowestPriceEnquiry $lowestPriceEnquiry,Promotion $promotion,float $priceExpected)
    {
        $servicePromition = new DateRangeSale();

        $priceCalculated = $servicePromition->calculate($lowestPriceEnquiry,$promotion,$lowestPriceEnquiry->getQuantity(),$price);

        self::assertSame($priceExpected,$priceCalculated);

    }

    /**
     * @dataProvider ProvideDataFixedPrice
     */
    public function testFixedPriceVoucher(float $price,LowestPriceEnquiry $lowestPriceEnquiry,Promotion $promotion,float $priceExpected )
    {

        $servicePromotion = new FixedPriceVoucher();
        $priceCalculated= $servicePromotion->calculate($lowestPriceEnquiry,$promotion,$lowestPriceEnquiry->getQuantity(),$price);

        self::assertSame($priceExpected,$priceCalculated);
    }

    public function ProvideDataFixedPrice()
    {
        $enquiry = new LowestPriceEnquiry();
        $quantity = 5;
        $adjustment = 100;
        $price = 155.25;
        $enquiry
            ->setQuantity($quantity)
            ->setVoucherCode('ABC')

        ;

        $promotion = new Promotion();
        $promotion->setCriteria(['code'=>'ABC'])
            ->setAdjustment($adjustment)
            ;

        $expectedFinalPrice = $adjustment * $quantity;

        yield 'hasPromo'=>[$price,$enquiry,$promotion,$expectedFinalPrice];


        // no promo
        $promotion = new Promotion();
        $promotion->setCriteria(['code'=>'ABCD'])
            ->setAdjustment($adjustment)
        ;

        $expectedFinalPrice = $price * $quantity;
        yield 'priceNoPromo'=> [$price,$enquiry,$promotion,$expectedFinalPrice];
    }


    public function ProvideEnquiryEven(): \Generator
    {
        $price = floatval(100);
        yield [$price,5,floatval(400)];
        yield [$price,3,floatval(250)];
        yield[$price,2,floatval(150) ];
        yield[$price,1,floatval(100) ];

    }


    public function ProvideDataDateRangeSale(): \Generator
    {
        $enquiry = new LowestPriceEnquiry();
        $quantity = 5;
        $adjustment = 0.5;
        $enquiry
            ->setQuantity($quantity)
            ->setRequestDate('2023-04-10')
            ;

        $price = 125.5;

        $promotion = new Promotion();
        $promotion->setAdjustment($adjustment);
        $promotion->setCriteria(['from'=> '2023-04-01','to'=>'2023-04-10'])
            ;

        $expectedFinalPrice = $price * $quantity * $adjustment;
        yield 'hasPromo'=>[$price,$enquiry,$promotion,$expectedFinalPrice];


        $enquiry = new LowestPriceEnquiry();
        $enquiry
            ->setQuantity($quantity)
            ->setRequestDate('2023-04-12')
        ;

        $promotion = new Promotion();
        $promotion->setAdjustment($adjustment);
        $promotion->setCriteria(['from'=> '2023-04-01','to'=>'2023-04-11'])
        ;

        $expectedFinalPrice = $price * $quantity;
        yield 'priceNoPromo'=> [$price,$enquiry,$promotion,$expectedFinalPrice];

    }



}
