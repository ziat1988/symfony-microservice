<?php

namespace App\Factory;

use App\Entity\ProductPromotion;
use App\Repository\ProductPromotionRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<ProductPromotion>
 *
 * @method        ProductPromotion|Proxy create(array|callable $attributes = [])
 * @method static ProductPromotion|Proxy createOne(array $attributes = [])
 * @method static ProductPromotion|Proxy find(object|array|mixed $criteria)
 * @method static ProductPromotion|Proxy findOrCreate(array $attributes)
 * @method static ProductPromotion|Proxy first(string $sortedField = 'id')
 * @method static ProductPromotion|Proxy last(string $sortedField = 'id')
 * @method static ProductPromotion|Proxy random(array $attributes = [])
 * @method static ProductPromotion|Proxy randomOrCreate(array $attributes = [])
 * @method static ProductPromotionRepository|RepositoryProxy repository()
 * @method static ProductPromotion[]|Proxy[] all()
 * @method static ProductPromotion[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static ProductPromotion[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static ProductPromotion[]|Proxy[] findBy(array $attributes)
 * @method static ProductPromotion[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ProductPromotion[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class ProductPromotionFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'product' => ProductFactory::new(),
            'promotion' => PromotionFactory::new(),
            'validTo'=>self::faker()->dateTimeBetween('now','2023-12-31','Europe/Paris')->setTime(0,0,0)
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            //     ->afterInstantiate(function(ProductPromotion $productPromotion): void {})
            ;
    }

    protected static function getClass(): string
    {
        return ProductPromotion::class;
    }
}
