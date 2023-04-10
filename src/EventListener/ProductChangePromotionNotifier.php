<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Cache\PromotionByProductCache;
use App\Entity\ProductPromotion;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use Psr\Cache\InvalidArgumentException;

use Symfony\Contracts\Cache\TagAwareCacheInterface;


#[AsEntityListener(event: Events::postPersist,method: 'postPersistHandler',entity: ProductPromotion::class)]
class ProductChangePromotionNotifier
{

    public function __construct(private TagAwareCacheInterface $cache)
    {
    }

    /**
     * @param ProductPromotion $productPromotion
     * @param PostPersistEventArgs $event
     * @return void
     * @throws InvalidArgumentException
     */
    public function postPersistHandler(ProductPromotion $productPromotion, PostPersistEventArgs $event) :void
    {

        // happen when a new entity success persist to db.
        $product = $productPromotion->getProduct();
        $this->cache->delete(PromotionByProductCache::KEY_NAME.$product->getId());
       // $this->cache->invalidateTags([PromotionByProductCache::TAG_NAME_CACHE.$product->getId()]);
    }

}
