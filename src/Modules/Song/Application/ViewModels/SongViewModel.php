<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\ViewModels;

use App\Modules\Song\Domain\Entities\Song;

final readonly class SongViewModel
{
    public function __construct(
        public string $id,
        public string $artistId,
        public string $name,
        public string $categoryId,
        public ?string $tag,
        public int $duration,
        public ?string $coverImage,
        public string $durationFormatted,
        public string $createdAt,
        public string $updatedAt,
        public ?string $deletedAt
    ) {}

    public static function fromEntity(Song $song): self
    {
        return new self(
            id: $song->getId()->getValue(),
            artistId: $song->getArtistId()->getValue(),
            name: $song->getName()->getValue(),
            categoryId: $song->getCategoryId()->getValue(),
            tag: $song->getTag()->getValue(),
            duration: $song->getDuration()->getSeconds(),
            coverImage: $song->getCoverImage()?->getValue(),
            durationFormatted: $song->getDuration()->getFormatted(),
            createdAt: $song->getCreatedAt()->format('Y-m-d H:i:s'),
            updatedAt: $song->getUpdatedAt()->format('Y-m-d H:i:s'),
            deletedAt: $song->getDeletedAt()?->format('Y-m-d H:i:s')
        );
    }
}
