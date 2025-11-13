<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\Entities;

use App\Modules\Song\Domain\ValueObjects\Album;
use App\Modules\Song\Domain\ValueObjects\Category;
use App\Modules\Song\Domain\ValueObjects\Duration;
use App\Modules\Song\Domain\ValueObjects\SongId;
use App\Modules\Song\Domain\ValueObjects\SongName;
use App\Modules\Song\Domain\ValueObjects\Tag;
use App\Modules\Song\Domain\ValueObjects\UserId;

class Song
{
    public function __construct(
        private readonly SongId             $id,
        private readonly UserId             $artistId,
        private SongName                    $name,
        private Category                    $category,
        private Album                       $album,
        private Tag                         $tag,
        private Duration                    $duration,
        private readonly \DateTimeImmutable $createdAt,
        private \DateTimeImmutable          $updatedAt,
        private ?\DateTimeImmutable         $deletedAt = null
    ) {}

    public static function create(
        SongId $id,
        UserId $artistId,
        SongName $name,
        Category $category,
        Album $album,
        Tag $tag,
        Duration $duration
    ): self
    {
        $now = new \DateTimeImmutable();

        return new self(
            $id,
            $artistId,
            $name,
            $category,
            $album,
            $tag,
            $duration,
            $now,
            $now
        );
    }

    public function update(
        SongName $name,
        Category $category,
        Album $album,
        Tag $tag,
        Duration $duration
    ): void
    {
        $this->name = $name;
        $this->category = $category;
        $this->album = $album;
        $this->tag = $tag;
        $this->duration = $duration;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function softDelete(): void
    {
        $this->deletedAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function restore(): void
    {
        $this->deletedAt = null;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }

    public function isOwnedBy(UserId $userId): bool
    {
        return $this->artistId->equals($userId);
    }


    public function getId(): SongId
    {
        return $this->id;
    }

    public function getArtistId(): UserId
    {
        return $this->artistId;
    }

    public function getName(): SongName
    {
        return $this->name;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getAlbum(): Album
    {
        return $this->album;
    }

    public function getTag(): Tag
    {
        return $this->tag;
    }

    public function getDuration(): Duration
    {
        return $this->duration;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
