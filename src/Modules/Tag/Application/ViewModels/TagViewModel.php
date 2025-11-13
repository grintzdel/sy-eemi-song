<?php

declare(strict_types=1);

namespace App\Modules\Tag\Application\ViewModels;

use App\Modules\Tag\Domain\Entities\Tag;
use DateTimeImmutable;

final readonly class TagViewModel
{
    public function __construct(
        public string $id,
        public string $name,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt
    ) {}

    public static function fromEntity(Tag $tag): self
    {
        return new self(
            id: $tag->getId()->getValue(),
            name: $tag->getName()->getValue(),
            createdAt: $tag->getCreatedAt(),
            updatedAt: $tag->getUpdatedAt()
        );
    }
}
