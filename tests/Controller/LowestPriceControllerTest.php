<?php

namespace App\Tests\Controller;

use App\Cache\PromotionByProductCache;
use App\EventListener\ProductChangePromotionNotifier;
use App\Tests\ApplicationTestCase;

use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;

class LowestPriceControllerTest extends ApplicationTestCase
{
    const ID_PRODUCT = 1;
    public function testRoutingProduct(): void
    {

        $uri = sprintf("/products/%d/lowest-price",self::ID_PRODUCT);

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
        $redisHost = getenv('REDIS_HOST');
        $redisPort = getenv('REDIS_PORT');
        $client = RedisAdapter::createConnection(sprintf('redis://%s:%s', $redisHost, $redisPort));

        $cache = new TagAwareAdapter(new RedisAdapter($client,namespace: 'my_app'));
        self::assertTrue($cache->hasItem(PromotionByProductCache::KEY_NAME.self::ID_PRODUCT));
    }
}
