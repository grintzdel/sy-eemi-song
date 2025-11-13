<?php

declare(strict_types=1);

namespace App\Modules\Album\Domain\Entities;

use App\Modules\Album\Domain\ValueObjects\AlbumId;
use App\Modules\Album\Domain\ValueObjects\AlbumName;
use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use App\Modules\Shared\Domain\ValueObjects\CoverImage;
use App\Modules\Shared\Domain\ValueObjects\UserId;

class Album
{
    public function __construct(
        private readonly AlbumId            $id,
        private readonly UserId             $artistId,
        private AlbumName                   $name,
        private ?CategoryId                 $categoryId,
        private ?CoverImage                 $coverImage,
        private readonly \DateTimeImmutable $createdAt,
        private \DateTimeImmutable          $updatedAt,
        private ?\DateTimeImmutable         $deletedAt = null
    ) {}

    public static function create(
        AlbumId $id,
        UserId $artistId,
        AlbumName $name,
        ?CategoryId $categoryId = null,
        ?CoverImage $coverImage = null
    ): self
    {
        $now = new \DateTimeImmutable();
        return new self(
            id: $id,
            artistId: $artistId,
            name: $name,
            categoryId: $categoryId,
            coverImage: $coverImage,
            createdAt: $now,
            updatedAt: $now
        );
    }

    public function update(AlbumName $name, ?CategoryId $categoryId = null, ?CoverImage $coverImage = null): void
    {
        $this->name = $name;
        $this->categoryId = $categoryId;
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

    public function isOwnedBy(UserId $userId): bool
    {
        return $this->artistId->getValue() === $userId->getValue();
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }

    public function getId(): AlbumId
    {
        return $this->id;
    }

    public function getArtistId(): UserId
    {
        return $this->artistId;
    }

    public function getName(): AlbumName
    {
        return $this->name;
    }

    public function getCategoryId(): ?CategoryId
    {
        return $this->categoryId;
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
