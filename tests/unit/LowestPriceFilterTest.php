<?php

namespace App\Tests\unit;

use App\Filter\LowestPriceFilter;
use App\Tests\ServiceTestCase;

class LowestPriceFilterTest extends ServiceTestCase
{
    /** @test */
    public function lowest_price_promotions_filtering_is_applied_correctly(): void
    {
        /** @var LowestPriceFilter $lowestPriceFilterService */
        $lowestPriceFilterService = $this->container->get(LowestPriceFilter::class);
        $lowestPriceFilterService->apply();
    }

}
