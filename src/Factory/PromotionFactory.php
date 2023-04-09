<?php

namespace App\Factory;

use App\Entity\Promotion;
use App\Repository\PromotionRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Promotion>
 *
 * @method        Promotion|Proxy create(array|callable $attributes = [])
 * @method static Promotion|Proxy createOne(array $attributes = [])
 * @method static Promotion|Proxy find(object|array|mixed $criteria)
 * @method static Promotion|Proxy findOrCreate(array $attributes)
 * @method static Promotion|Proxy first(string $sortedField = 'id')
 * @method static Promotion|Proxy last(string $sortedField = 'id')
 * @method static Promotion|Proxy random(array $attributes = [])
 * @method static Promotion|Proxy randomOrCreate(array $attributes = [])
 * @method static PromotionRepository|RepositoryProxy repository()
 * @method static Promotion[]|Proxy[] all()
 * @method static Promotion[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Promotion[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Promotion[]|Proxy[] findBy(array $attributes)
 * @method static Promotion[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Promotion[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class PromotionFactory extends ModelFactory
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
            'adjustment' => self::faker()->randomFloat(),
            'criteria' => [],
            'name' => self::faker()->text(255),
            'type' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Promotion $promotion): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Promotion::class;
    }
}
