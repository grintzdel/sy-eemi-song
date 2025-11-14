<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Modules\Tag\Infrastructure\Doctrine\Entities\TagEntity;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

final class TagFixtures extends Fixture
{
    private Generator $faker;

    public const array TAGS = [
        'Chill',
        'Energetic',
        'Vintage',
        'Modern',
        'Acoustic',
        'Live',
        'Remix',
        'Cover',
        'Instrumental',
        'Upbeat',
        'Melancholic',
        'Dance',
        'Ambient',
        'Lo-fi',
        'Experimental',
        'Underground',
        'Mainstream',
        'Indie',
        'Retro',
        'Epic',
    ];

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::TAGS as $index => $name) {
            $tag = new TagEntity(
                id: $this->faker->uuid(),
                name: $name,
                createdAt: new DateTimeImmutable(),
                updatedAt: new DateTimeImmutable()
            );

            $manager->persist($tag);

            $this->addReference('tag_' . $index, $tag);
        }

        $manager->flush();
    }
}
