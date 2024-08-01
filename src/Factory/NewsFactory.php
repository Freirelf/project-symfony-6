<?php

namespace App\Factory;

use App\Entity\News;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<News>
 */
final class NewsFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return News::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {   
        $dateTime = self::faker()->dateTimeBetween('-90 days', 'now');
        return [
            'createAt' => \DateTimeImmutable::createFromMutable($dateTime),
            'description' => self::faker()->text(255),
            'slug' => self::faker()->text(255),
            'title' => self::faker()->text(255),
            'image' => 'https://loremflickr.com/419/225/' . rand(1000, 10000),
            'content' => self::faker()->sentence(30, true),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(News $news): void {})
        ;
    }
}
