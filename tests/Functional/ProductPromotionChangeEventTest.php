<?php
declare(strict_types=1);

namespace App\Tests\Functional;

use App\Cache\PromotionByProductCache;
use App\Entity\Product;
use App\Factory\ProductFactory;
use App\Factory\ProductPromotionFactory;
use App\Factory\PromotionFactory;
use App\Tests\FunctionalTestCase;
use App\Utils\RedisUtils;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;


class ProductPromotionChangeEventTest extends FunctionalTestCase
{

    /**
     * @throws InvalidArgumentException
     */
    public function testRedisKeyDeleteByPostPersistHandler()
    {
        /** @var Product $product */
        $product= ProductFactory::randomOrCreate()->object();

        //writing a key to redis
       /** @var PromotionByProductCache $serviceProductCache */
       $serviceProductCache = $this->container->get(PromotionByProductCache::class);
       $serviceProductCache->findPromotionForProduct($product);


        // add new ProductPromotion
        ProductPromotionFactory::createOne([
            'product'=>$product,
            'promotion'=>PromotionFactory::random()
        ]);


        // event trigger & key must be deleted
        $client = RedisUtils::createConnectionRedis();
        $cache = RedisUtils::getCache($client);
        self::assertFalse($cache->hasItem(PromotionByProductCache::KEY_NAME.$product->getId()));

    }
    public function testMockingPersistProduct()
    {
        //$product = new Product();
        // $product->setPrice("55.5");

        $product = ProductFactory::new();

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($product))
        ;

        // persist the product using the mocked entity manager
        $entityManager->persist($product);
    }

}
