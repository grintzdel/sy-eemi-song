<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\ViewModels;

final readonly class AlbumViewModel
{
    public function __construct(
        public string $id,
        public string $authorId,
        public string $name,
        public ?string $categoryId,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
        public ?\DateTimeImmutable $deletedAt = null
    ) {}
}
