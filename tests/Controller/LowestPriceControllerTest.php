<?php

namespace App\Tests\Controller;

use App\Cache\PromotionByProductCache;
use App\Factory\ProductFactory;
use App\Tests\ApplicationTestCase;
use App\Utils\RedisUtils;

class LowestPriceControllerTest extends ApplicationTestCase
{

    private static int $ID_PRODUCT;

    private static \Redis $redisClient;

    /**
     * @dataProvider numberOfTestRun
     */
    public function testRoutingProduct(): void
    {
        $product = ProductFactory::randomOrCreate();

        self::$ID_PRODUCT = $product->getId();


        $uri = sprintf("/products/%d/lowest-price",$product->getId());

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


    public function numberOfTestRun() : \Generator
    {
        $time = 3;
        for($i = 1; $i<= $time; $i++ ){
            yield[];
        }
    }

    /**
     * @depends testRoutingProduct
     */
    public function testKeyAddToRedisSuccess()
    {
        self::$redisClient = RedisUtils::createConnectionRedis();
        $cache = RedisUtils::getCache(self::$redisClient);
        self::assertTrue($cache->hasItem(PromotionByProductCache::KEY_NAME.self::$ID_PRODUCT));
    }


    /**
     * @throws \RedisException
     */
    public static function tearDownAfterClass(): void
    {
        //clean up all key redis
        $redisAdapter = self::$redisClient;
        $keys = $redisAdapter->keys('my_app:*');

        $redisAdapter->del($keys);
    }
}
