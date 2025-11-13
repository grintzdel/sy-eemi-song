<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\Entities;

use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use App\Modules\Shared\Domain\ValueObjects\CoverImage;
use App\Modules\Shared\Domain\ValueObjects\SongId;
use App\Modules\Shared\Domain\ValueObjects\UserId;
use App\Modules\Song\Domain\ValueObjects\SongDuration;
use App\Modules\Song\Domain\ValueObjects\SongName;
use App\Modules\Song\Domain\ValueObjects\SongTag;

class Song
{
    public function __construct(
        private readonly SongId             $id,
        private readonly UserId             $artistId,
        private SongName                    $name,
        private CategoryId                  $categoryId,
        private SongTag                     $tag,
        private SongDuration                $duration,
        private ?CoverImage                 $coverImage,
        private readonly \DateTimeImmutable $createdAt,
        private \DateTimeImmutable          $updatedAt,
        private ?\DateTimeImmutable         $deletedAt = null
    ) {}

    public static function create(
        SongId       $id,
        UserId       $artistId,
        SongName     $name,
        CategoryId   $categoryId,
        SongTag      $tag,
        SongDuration $duration,
        ?CoverImage  $coverImage = null
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
            $coverImage,
            $now,
            $now
        );
    }

    public function update(
        SongName     $name,
        CategoryId   $categoryId,
        SongTag      $tag,
        SongDuration $duration,
        ?CoverImage  $coverImage = null
    ): void
    {
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->tag = $tag;
        $this->duration = $duration;
        $this->coverImage = $coverImage;
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

    public function getTag(): SongTag
    {
        return $this->tag;
    }

    public function getDuration(): SongDuration
    {
        return $this->duration;
    }

    public function getCoverImage(): ?CoverImage
    {
        return $this->coverImage;
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
