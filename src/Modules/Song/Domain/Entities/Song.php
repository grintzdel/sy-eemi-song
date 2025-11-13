<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\Entities;

use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use App\Modules\Song\Domain\ValueObjects\SongDuration;
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
        private CategoryId                  $categoryId,
        private Tag                         $tag,
        private SongDuration                $duration,
        private readonly \DateTimeImmutable $createdAt,
        private \DateTimeImmutable          $updatedAt,
        private ?\DateTimeImmutable         $deletedAt = null
    ) {}

    public static function create(
        SongId $id,
        UserId $artistId,
        SongName $name,
        CategoryId $categoryId,
        Tag $tag,
        SongDuration $duration
    ): self
    {
        $now = new \DateTimeImmutable();

        return new self(
            $id,
            $artistId,
            $name,
            $categoryId,
            $tag,
            $duration,
            $now,
            $now
        );
    }

    public function update(
        SongName $name,
        CategoryId $categoryId,
        Tag $tag,
        SongDuration $duration
    ): void
    {
        $this->name = $name;
        $this->categoryId = $categoryId;
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

    public function getCategoryId(): CategoryId
    {
        return $this->categoryId;
    }

    public function getTag(): Tag
    {
        return $this->tag;
    }

    public function getDuration(): SongDuration
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
