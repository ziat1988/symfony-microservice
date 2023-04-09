<?php

namespace App\Tests\Controller;

use App\Cache\PromotionByProductCache;
use App\Tests\ApplicationTestCase;
use App\Utils\RedisUtils;

class LowestPriceControllerTest extends ApplicationTestCase
{
    public function testRoutingProduct(): void
    {

        $uri = sprintf("/products/%d/lowest-price",RedisUtils::ID_PRODUCT_TEST);

        $crawler = $this->client->jsonRequest('POST', $uri,
            [
                'quantity'=>5,
                'requestLocation'=>'FR',
                'voucherCode'=> 'OU812',
                'requestDate'=>'2023-11-25',
            ]
        );

        $this->assertResponseIsSuccessful();

    }

    /**
     * @depends testRoutingProduct
     */
    public function testKeyAddToRedisSuccess()
    {
        $client = RedisUtils::createConnectionRedis();
        $cache = RedisUtils::getCache($client);
        self::assertTrue($cache->hasItem(PromotionByProductCache::KEY_NAME.RedisUtils::ID_PRODUCT_TEST));
    }


}
