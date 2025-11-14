<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Modules\Category\Infrastructure\Doctrine\Entities\CategoryEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

final class CategoryFixtures extends Fixture
{
    private Generator $faker;

    public const array CATEGORIES = [
        'Rock' => 'A genre of popular music that originated as "rock and roll" in the United States.',
        'Pop' => 'Popular music is eclectic, and often borrows elements from other styles.',
        'Jazz' => 'A music genre that originated in the African-American communities.',
        'Hip-Hop' => 'A cultural movement and music genre developed in the United States.',
        'Electronic' => 'Music that employs electronic musical instruments and technology.',
        'Classical' => 'Art music produced or rooted in Western liturgical and secular music.',
        'R&B' => 'Rhythm and blues, a genre of popular music that originated in African-American communities.',
        'Country' => 'A genre of American popular music that originated in the Southern United States.',
        'Metal' => 'A genre of rock music that developed in the late 1960s and early 1970s.',
        'Reggae' => 'A music genre that originated in Jamaica in the late 1960s.',
    ];

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $name => $description) {
            $category = new CategoryEntity(
                id: $this->faker->uuid(),
                name: $name,
                description: $description,
                createdAt: new \DateTimeImmutable(),
                updatedAt: new \DateTimeImmutable()
            );

            $manager->persist($category);

            $this->addReference('category_'.strtolower($name), $category);
        }

        $manager->flush();
    }
}
