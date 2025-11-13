<?php

declare(strict_types=1);

namespace App\Modules\Album\Domain\Entities;

use App\Modules\Album\Domain\ValueObjects\AlbumId;
use App\Modules\Album\Domain\ValueObjects\AlbumName;
use App\Modules\Song\Domain\ValueObjects\UserId;

class Album
{
    public function __construct(
        private readonly AlbumId            $id,
        private readonly UserId             $authorId,
        private AlbumName                   $name,
        private readonly \DateTimeImmutable $createdAt,
        private \DateTimeImmutable          $updatedAt,
        private ?\DateTimeImmutable         $deletedAt = null
    ) {}

    public static function create(
        AlbumId $id,
        UserId $authorId,
        AlbumName $name
    ): self
    {
        $now = new \DateTimeImmutable();
        return new self(
            id: $id,
            authorId: $authorId,
            name: $name,
            createdAt: $now,
            updatedAt: $now
        );
    }

    public function update(AlbumName $name): void
    {
        $this->name = $name;
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
        return $this->authorId->getValue() === $userId->getValue();
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }

    public function getId(): AlbumId
    {
        return $this->id;
    }

    public function getAuthorId(): UserId
    {
        return $this->authorId;
    }

    public function getName(): AlbumName
    {
        return $this->name;
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
