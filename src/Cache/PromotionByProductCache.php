<?php
declare(strict_types=1);

namespace App\Cache;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Repository\PromotionRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

readonly class PromotionByProductCache
{
    public function __construct(private CacheInterface $cache, private PromotionRepository $promotionRepository)
    {}

    /**
     * @param Product $product
     * @return array<int, Promotion>|null
     * @throws InvalidArgumentException
     */
    public function findPromotionForProduct(Product $product) : ?array
    {
        $key = sprintf("promotion-by-product-%d",$product->getId());
        return $this->cache->get($key,function (ItemInterface $item)  use ($product){
            $item->expiresAfter(3600);
            var_dump('miss');
            return $this->promotionRepository->getPromotionByProduct($product);
        });

    }

}
