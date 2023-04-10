<?php
declare(strict_types=1);

namespace App\Cache;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Repository\PromotionRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class PromotionByProductCache
{
    const TAG_NAME_CACHE = "tag_product_";
    const KEY_NAME = "product-";


    public function __construct(private TagAwareCacheInterface $cache, private PromotionRepository $promotionRepository)
    {}

    /**
     * @param Product $product
     * @return array<int, Promotion>|null
     * @throws InvalidArgumentException
     */
    public function findPromotionForProduct(Product $product) : ?array
    {
        return $this->cache->get(self::KEY_NAME.$product->getId(),function (ItemInterface $item)  use ($product){
            $item->expiresAfter(3600);
            return $this->promotionRepository->getPromotionByProduct($product);
        });

    }

}
