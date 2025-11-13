<?php

declare(strict_types=1);

namespace App\Modules\Category\Domain\Entities;

use App\Modules\Category\Domain\ValueObjects\CategoryName;
use App\Modules\Category\Domain\ValueObjects\CategoryDescription;
use App\Modules\Shared\Domain\ValueObjects\CategoryId;

final class Category
{
    public function __construct(
        private readonly CategoryId         $id,
        private CategoryName                $name,
        private CategoryDescription         $description,
        private readonly \DateTimeImmutable $createdAt,
        private \DateTimeImmutable          $updatedAt,
        private ?\DateTimeImmutable         $deletedAt = null
    ) {}

    public static function create(
        CategoryId $id,
        CategoryName $name,
        CategoryDescription $description
    ): self
    {
        $now = new \DateTimeImmutable();

        return new self(
            id: $id,
            name: $name,
            description: $description,
            createdAt: $now,
            updatedAt: $now
        );
    }

    public function update(CategoryName $name, CategoryDescription $description): void
    {
        $this->name = $name;
        $this->description = $description;
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

    public function getId(): CategoryId
    {
        return $this->id;
    }

    public function getName(): CategoryName
    {
        return $this->name;
    }

    public function getDescription(): CategoryDescription
    {
        return $this->description;
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
