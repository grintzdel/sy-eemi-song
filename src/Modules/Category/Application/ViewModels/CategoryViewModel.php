<?php

declare(strict_types=1);

namespace App\Modules\Category\Application\ViewModels;

final readonly class CategoryViewModel
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
        public ?\DateTimeImmutable $deletedAt = null
    ) {}
}
