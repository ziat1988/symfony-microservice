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

    /**
     * @dataProvider provideJsonData
     */
    public function testLowestPriceAppliedCorrect(LowestPriceEnquiry $enquiry, Product $product, float|null $priceDiscount): void
    {

        $lowestPriceFilterService = new LowestPriceFilter();
        $promotions = $this->getPromotions(); // many promotion applied to product

        $priceFiltered = $lowestPriceFilterService->apply($enquiry,$promotions);

        self::assertSame($priceFiltered->getDiscountedPrice(),$priceDiscount);
        self::assertSame($priceFiltered->getOriginalPrice(),floatval($product->getPrice()));

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
        $promotionOne->setAdjustment(0.5);
        $promotionOne->setCriteria(["from" => "2023-11-25", "to" => "2023-11-28"]);
        $promotionOne->setType('date_range_multiplier');

        yield 'half price date range'=> [[$promotionOne]];

        $promotionTwo = new Promotion();
        $promotionTwo->setName('Voucher');
        $promotionTwo->setAdjustment(100);
        $promotionTwo->setCriteria(["code" => "OU812"]);
        $promotionTwo->setType('fixed_price_voucher');

        yield '2 promotions with product'=> [[$promotionOne,$promotionTwo]];
    }

    public function provideJsonData(): \Generator
    {

        $product = new Product();
        $product->setPrice(122.5);
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setProduct($product)
            ->setQuantity(2)
            ->setVoucherCode('OU812')
            ->setRequestDate('2023-04-01');

        yield 'sale_fixed'=> [$enquiry,$product,100*2];

        $product = new Product();
        $product->setPrice(100);
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setProduct($product)
            ->setQuantity(5)
            ->setVoucherCode('OU812')
            ->setRequestDate('2023-11-25');

        yield 'half_price_sale'=>[$enquiry,$product,(100*5)/2];

        $product = new Product();
        $product->setPrice(99);
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setProduct($product)
            ->setQuantity(5)
            ->setVoucherCode('OU812x')
            ->setRequestDate('2023-11-24');

        yield 'no_promotion'=>[$enquiry,$product,null];
    }

    private function getPromotions(): array
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
