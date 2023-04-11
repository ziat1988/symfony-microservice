<?php

namespace App\Tests\unit;
use App\DTO\LowestPriceEnquiry;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Factory\ProductFactory;
use App\FilterPrice\LowestPriceFilter;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

class LowestPriceFilterTest extends TestCase
{
    use Factories;
    const PROMO_PRICE_FIXED = 100.00;
    const ADJUST_DATE_RANGE = 0.5;

    /**
     * @param array $promotions
     * @return void
     * @dataProvider providePromotionsForEvenItem
     */
    public function testLowestPriceEvenItemApplied(array $promotions) :void
    {
        // even promo < voucher : 100 + 50 + 100 < 100 + 100 +100
        $product = new Product();
        $product->setPrice(100.00);
        $enquiry = new LowestPriceEnquiry();
        $enquiry
            ->setProduct($product)
            ->setQuantity(3)
            ->setRequestDate('2023-12-28')
            ->setVoucherCode('OU812')

        ;

        $lowestPriceFilterService = new LowestPriceFilter();
        $priceProduct = floatval($product->getPrice());
        $priceFiltered = $lowestPriceFilterService->apply($enquiry,$promotions);


        self::assertSame(floatval(250),$priceFiltered->getDiscountedPrice());
        self::assertSame($priceProduct * $enquiry->getQuantity(), $priceFiltered->getTotalOriginalPrice());
        self::assertSame($priceProduct, $priceFiltered->getOriginalPrice());
        self::assertLessThan($priceFiltered->getTotalOriginalPrice(),$priceFiltered->getDiscountedPrice(),'total discount must less than total original price' );

    }

    /**
     * @param array<int, Promotion> $promotions
     * @return void
     * @dataProvider providePromotions
     */
    public function testLowestPriceWithHalfPriceByDateValid(array $promotions): void
    {
        // two promotion but the one lowest will be applied
        // 110 * 4 *0.5 = 220 < 100 * 4 = 400

        $product = new Product();
        $product->setPrice(110);
        $enquiry = new LowestPriceEnquiry();
        $enquiry
            ->setProduct($product)
            ->setQuantity(4)
            ->setRequestDate('2023-11-28')
            ->setVoucherCode('OU812')

        ;

        $lowestPriceFilterService = new LowestPriceFilter();
        $priceProduct = floatval($product->getPrice());
        $priceFiltered = $lowestPriceFilterService->apply($enquiry,$promotions);


        self::assertSame($priceProduct * $enquiry->getQuantity() * self::ADJUST_DATE_RANGE,$priceFiltered->getDiscountedPrice());
        self::assertSame($priceProduct * $enquiry->getQuantity(), $priceFiltered->getTotalOriginalPrice());
        self::assertSame($priceProduct, $priceFiltered->getOriginalPrice());
        self::assertLessThan($priceFiltered->getTotalOriginalPrice(),$priceFiltered->getDiscountedPrice(),'total discount must less than total original price' );


    }

    /**
     * @param array<int, Promotion> $promotions
     * @return void
     * @dataProvider providePromotions
     */
    public function testLowestPriceWithVoucherValid(array $promotions): void
    {
        $product = ProductFactory::randomOrCreate()->object();
        $enquiry = new LowestPriceEnquiry();
        $enquiry
            ->setProduct($product)
            ->setQuantity(4)
            ->setRequestDate('2023-11-01')
            ->setVoucherCode('OU812')

        ;

        $lowestPriceFilterService = new LowestPriceFilter();
        $priceProduct = floatval($product->getPrice());
        $priceFiltered = $lowestPriceFilterService->apply($enquiry,$promotions);



        self::assertSame(self::PROMO_PRICE_FIXED * $enquiry->getQuantity(),$priceFiltered->getDiscountedPrice());
        self::assertSame($priceProduct * $enquiry->getQuantity(), $priceFiltered->getTotalOriginalPrice());
        self::assertSame($priceProduct, $priceFiltered->getOriginalPrice());
        self::assertLessThan($priceFiltered->getTotalOriginalPrice(),$priceFiltered->getDiscountedPrice(),'total discount must less than total original price' );
    }


    /**
     * @param array<int,Promotion> $promotions
     * @return void
     * @dataProvider providePromotions
     */
    public function testProductHasPromoNotValid(array $promotions) :void
    {
        $product = ProductFactory::randomOrCreate()->object();
        $enquiry = new LowestPriceEnquiry();
        $enquiry
            ->setProduct($product)
            ->setQuantity(4)
            ->setRequestDate('2023-12-01')
            ->setVoucherCode('ABC')

        ;

        $lowestPriceFilterService = new LowestPriceFilter();
        $priceProduct = floatval($product->getPrice());


        $priceFiltered = $lowestPriceFilterService->apply($enquiry,$promotions);

        self::assertSame( $priceProduct, $priceFiltered->getOriginalPrice());
        self::assertSame( $priceProduct * $enquiry->getQuantity(), $priceFiltered->getTotalOriginalPrice());
        self::assertSame( null, $priceFiltered->getDiscountedPrice());
    }



    public function providePromotions(): \Generator
    {
        $promotionOne = new Promotion();
        $promotionOne->setName('Black Friday half price sale');
        $promotionOne->setAdjustment(self::ADJUST_DATE_RANGE);
        $promotionOne->setCriteria(["from" => "2023-11-25", "to" => "2023-11-28"]);
        $promotionOne->setType('date_range_multiplier');

        $promotionTwo = new Promotion();
        $promotionTwo->setName('Voucher');
        $promotionTwo->setAdjustment(self::PROMO_PRICE_FIXED);
        $promotionTwo->setCriteria(["code" => "OU812"]);
        $promotionTwo->setType('fixed_price_voucher');

        yield '2 promotions with product'=> [[$promotionOne,$promotionTwo]];
    }


    public function providePromotionsForEvenItem(): \Generator
    {
        $promotionOne = new Promotion();
        $promotionOne->setName('Black Friday half price sale');
        $promotionOne->setAdjustment(self::ADJUST_DATE_RANGE);
        $promotionOne->setCriteria(["from" => "2023-11-25", "to" => "2023-11-28"]);
        $promotionOne->setType('date_range_multiplier');

        $promotionTwo = new Promotion();
        $promotionTwo->setName('Voucher');
        $promotionTwo->setAdjustment(self::PROMO_PRICE_FIXED);
        $promotionTwo->setCriteria(["code" => "OU812"]);
        $promotionTwo->setType('fixed_price_voucher');

        $promotionThree = new Promotion();
        $promotionThree->setName('Buy one get one free');
        $promotionThree->setAdjustment(0.5);
        $promotionThree->setCriteria(["minimum_quantity" => 2]);
        $promotionThree->setType('even_items_multiplier');


        yield '3 promotions with product'=> [[$promotionOne,$promotionTwo,$promotionThree]];
    }

}
