<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Modules\Album\Infrastructure\Doctrine\Entities\AlbumEntity;
use App\Modules\Category\Infrastructure\Doctrine\Entities\CategoryEntity;
use App\Modules\Song\Infrastructure\Doctrine\Entities\SongEntity;
use App\Modules\Tag\Infrastructure\Doctrine\Entities\TagEntity;
use App\Modules\User\Infrastructure\Doctrine\Entities\UserEntity;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

final class SongFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 150; $i++) {
            $artistIndex = $this->faker->numberBetween(1, 10);
            /** @var UserEntity $artist */
            $artist = $this->getReference('user_artist_' . $artistIndex, UserEntity::class);

            $categoryKeys = array_keys(CategoryFixtures::CATEGORIES);
            $randomCategory = $this->faker->randomElement($categoryKeys);
            /** @var CategoryEntity $category */
            $category = $this->getReference('category_' . strtolower($randomCategory), CategoryEntity::class);

            $tagId = null;
            if ($this->faker->boolean(50)) {
                $tagIndex = $this->faker->numberBetween(0, count(TagFixtures::TAGS) - 1);
                /** @var TagEntity $tag */
                $tag = $this->getReference('tag_' . $tagIndex, TagEntity::class);
                $tagId = $tag->getId();
            }

            $coverImage = null;
            if ($this->faker->boolean(50)) {
                $coverImage = $this->faker->imageUrl(640, 480, 'music', true);
            }

            $song = new SongEntity(
                id: $this->faker->uuid(),
                artistId: $artist->getId(),
                name: $this->generateSongName(),
                categoryId: $category->getId(),
                tagId: $tagId,
                duration: $this->faker->numberBetween(120, 300),
                coverImage: $coverImage,
                createdAt: new DateTimeImmutable(),
                updatedAt: new DateTimeImmutable()
            );

            $manager->persist($song);

            if ($this->faker->boolean(80)) {
                $numberOfAlbums = $this->faker->numberBetween(2, 5);
                $albumIndexes = $this->faker->randomElements(range(1, 50), $numberOfAlbums);

                foreach ($albumIndexes as $albumIndex) {
                    /** @var AlbumEntity $album */
                    $album = $this->getReference('album_' . $albumIndex, AlbumEntity::class);
                    $song->addAlbum($album);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            TagFixtures::class,
            UserFixtures::class,
            AlbumFixtures::class,
        ];
    }

    private function generateSongName(): string
    {
        $songWords = [
            'Love',
            'Heart',
            'Night',
            'Day',
            'Light',
            'Dark',
            'Fire',
            'Rain',
            'Sky',
            'Stars',
            'Moon',
            'Sun',
            'Wind',
            'Ocean',
            'River',
            'Mountain',
            'Dance',
            'Dream',
            'Hope',
            'Time',
            'Life',
            'Soul',
            'Spirit',
            'Freedom',
            'Peace',
        ];

        $connectors = ['in the', 'of', 'and', 'on the', 'under the', 'with', 'without'];

        if ($this->faker->boolean(40)) {
            return $this->faker->randomElement($songWords);
        }

        return $this->faker->randomElement($songWords) . ' ' . $this->faker->randomElement($connectors) . ' ' . $this->faker->randomElement($songWords);
    }
}
