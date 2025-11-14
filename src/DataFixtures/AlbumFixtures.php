<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Modules\Album\Infrastructure\Doctrine\Entities\AlbumEntity;
use App\Modules\Category\Infrastructure\Doctrine\Entities\CategoryEntity;
use App\Modules\User\Infrastructure\Doctrine\Entities\UserEntity;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

final class AlbumFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $artistIndex = $this->faker->numberBetween(1, 10);
            /** @var UserEntity $artist */
            $artist = $this->getReference('user_artist_' . $artistIndex, UserEntity::class);

            $categoryId = null;
            if ($this->faker->boolean(70)) {
                $categoryKeys = array_keys(CategoryFixtures::CATEGORIES);
                $randomCategory = $this->faker->randomElement($categoryKeys);
                /** @var CategoryEntity $category */
                $category = $this->getReference('category_' . strtolower($randomCategory), CategoryEntity::class);
                $categoryId = $category->getId();
            }

            $coverImage = null;
            if ($this->faker->boolean(60)) {
                $coverImage = 'https://picsum.photos/640/480';
            }

            $album = new AlbumEntity(
                id: $this->faker->uuid(),
                artistId: $artist->getId(),
                name: $this->generateAlbumName(),
                categoryId: $categoryId,
                coverImage: $coverImage,
                createdAt: new DateTimeImmutable(),
                updatedAt: new DateTimeImmutable()
            );

            $manager->persist($album);

            $this->addReference('album_' . $i, $album);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }

    private function generateAlbumName(): string
    {
        $albumTypes = [
            'Greatest Hits',
            'Live in Concert',
            'The Best of',
            'Collection',
            'Anthology',
            'Studio Sessions',
        ];

        $albumWords = [
            'Dreams',
            'Journey',
            'Echoes',
            'Horizons',
            'Midnight',
            'Sunrise',
            'Thunder',
            'Whispers',
            'Flames',
            'Shadows',
            'Reflections',
            'Moments',
            'Memories',
            'Stories',
            'Legends',
        ];

        if ($this->faker->boolean(30)) {
            return $this->faker->randomElement($albumTypes);
        }

        return $this->faker->randomElement($albumWords) . ' ' . $this->faker->randomElement(['and', 'of', 'in']) . ' ' . $this->faker->randomElement($albumWords);
    }
}
