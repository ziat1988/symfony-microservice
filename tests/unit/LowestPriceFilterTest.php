<?php

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;
use App\FilterPrice\LowestPriceFilter;
use App\Tests\ServiceTestCase;

class LowestPriceFilterTest extends ServiceTestCase
{
    /**
     * @dataProvider provideJsonData
     */
    public function testLowestPriceAppliedCorrect(LowestPriceEnquiry $enquiry, float $priceFinalExpected): void
    {

        /** @var LowestPriceFilter $lowestPriceFilterService */
        $lowestPriceFilterService = $this->container->get(LowestPriceFilter::class);
        $promotions = $this->providePromotions();


        $priceFiltered = $lowestPriceFilterService->apply($enquiry,$promotions);
        self::assertSame($priceFiltered->getFinalTotalPrice(),$priceFinalExpected);

    }

    public function provideJsonData(): \Generator
    {

        $enquiry = new LowestPriceEnquiry();
        $enquiry->setPrice(122.5)
            ->setQuantity(2)
            ->setVoucherCode('OU812')
            ->setRequestDate('2023-04-01');

        yield 'sale_fixed'=> [$enquiry,100*2];


        $enquiry = new LowestPriceEnquiry();
        $enquiry->setPrice(100)
            ->setQuantity(5)
            ->setVoucherCode('OU812')
            ->setRequestDate('2023-11-25');

        yield 'half_price_sale'=>[$enquiry,(100*5)/2];


        $enquiry = new LowestPriceEnquiry();
        $enquiry->setPrice(99)
            ->setQuantity(5)
            ->setVoucherCode('OU812x')
            ->setRequestDate('2023-11-24');

        yield 'no_promotion'=>[$enquiry,99*5];
    }

    private function providePromotions(): array
    {
        $promotionOne = new Promotion();
        $promotionOne->setName('Black Friday half price sale');
        $promotionOne->setAdjustment(0.5);
        $promotionOne->setCriteria(["from" => "2023-11-25", "to" => "2023-11-28"]);
        $promotionOne->setType('date_range_multiplier');

        $promotionTwo = new Promotion();
        $promotionTwo->setName('Voucher OU812');
        $promotionTwo->setAdjustment(100);
        $promotionTwo->setCriteria(["code" => "OU812"]);
        $promotionTwo->setType('fixed_price_voucher');

        /*
        $promotionThree = new Promotion();
        $promotionThree->setName('Buy one get one free');
        $promotionThree->setAdjustment(0.5);
        $promotionThree->setCriteria(["minimum_quantity" => 2]);
        $promotionThree->setType('even_items_multiplier');
        */

        return [$promotionOne, $promotionTwo];
    }

}
