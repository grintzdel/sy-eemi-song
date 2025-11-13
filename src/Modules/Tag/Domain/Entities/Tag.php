<?php

declare(strict_types=1);

namespace App\Modules\Tag\Domain\Entities;

use App\Modules\Shared\Domain\ValueObjects\TagId;
use App\Modules\Tag\Domain\ValueObjects\TagName;
use DateTimeImmutable;

final class Tag
{
    public function __construct(
        private readonly TagId $id,
        private TagName $name,
        private readonly DateTimeImmutable $createdAt,
        private DateTimeImmutable $updatedAt,
        private ?DateTimeImmutable $deletedAt = null
    ) {}

    public static function create(
        TagName $name
    ): self {
        $now = new DateTimeImmutable();

        return new self(
            id: TagId::generate(),
            name: $name,
            createdAt: $now,
            updatedAt: $now
        );
    }

    public function update(TagName $name): void
    {
        $this->name = $name;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function delete(): void
    {
        $this->deletedAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): TagId
    {
        return $this->id;
    }

    public function getName(): TagName
    {
        return $this->name;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }
}
