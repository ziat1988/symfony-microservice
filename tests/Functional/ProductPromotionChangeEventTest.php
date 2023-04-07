<?php
declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\Product;
use App\Entity\ProductPromotion;
use App\Entity\Promotion;
use App\Tests\FunctionalTestCase;

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;


class ProductPromotionChangeEventTest extends FunctionalTestCase
{

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function testNewProductPromotionInsert()
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

        self::assertTrue(true);
    }

}
