<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Cache\PromotionByProductCache;
use App\Entity\ProductPromotion;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use Psr\Cache\InvalidArgumentException;

use Symfony\Contracts\Cache\ItemInterface;
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


    /**
     * @throws InvalidArgumentException
     */
    public function invalidateTagCache(): void
    {
        //$this->cache->invalidateTags(['tag']);
        $this->cache->delete('product-1');
    }


    /**
     * @throws InvalidArgumentException
     */
    public function createTag()
    {
        $this->cache->get('product-1',function (ItemInterface $item){
           $item->tag('tag');
           var_dump('key found');
           return 'this is just some rand text';
        });
    }
}
