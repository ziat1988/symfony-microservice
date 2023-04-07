<?php
declare(strict_types=1);

namespace App\Tests\Functional;

use App\Cache\PromotionByProductCache;
use App\Entity\Product;
use App\Entity\ProductPromotion;
use App\Entity\Promotion;
use App\Tests\FunctionalTestCase;

use App\Utils\RedisUtils;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Cache\InvalidArgumentException;


class ProductPromotionChangeEventTest extends FunctionalTestCase
{

    /**
     * @throws OptimisticLockException
     * @throws ORMException|InvalidArgumentException
     */
    public function testNewProductPromotionInsertThenKeyRedisDeleted()
    {
        $product = $this->entityManager->getRepository(Product::class)->find(1);

        $promotion = $this->entityManager->getRepository(Promotion::class)->find(3);

        $this->entityManager->persist($product);
        $this->entityManager->persist($promotion);

        $pp = new ProductPromotion();
        $pp->setProduct($product);
        $pp->setPromotion($promotion);

        $this->entityManager->persist($pp);
        $this->entityManager->flush();


        // event trigger & key must be deleted

        $client = RedisUtils::createConnectionRedis();
        $cache = RedisUtils::getCache($client);
        self::assertFalse($cache->hasItem(PromotionByProductCache::KEY_NAME.RedisUtils::ID_PRODUCT_TEST));
    }

}
