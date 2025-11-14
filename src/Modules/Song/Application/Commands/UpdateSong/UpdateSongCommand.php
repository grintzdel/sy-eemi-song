<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Commands\UpdateSong;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateSongCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'Song ID is required')]
        #[Assert\Uuid(message: 'Song ID must be a valid UUID')]
        private string $id,

        #[Assert\NotBlank(message: 'Song name is required')]
        #[Assert\Length(max: 255, maxMessage: 'Song name cannot exceed 255 characters')]
        private string $name,

        #[Assert\NotBlank(message: 'Category ID is required')]
        #[Assert\Uuid(message: 'Category ID must be a valid UUID')]
        private string $categoryId,

        #[Assert\Uuid(message: 'Tag ID must be a valid UUID')]
        private ?string $tagId,

        #[Assert\NotBlank(message: 'Duration is required')]
        #[Assert\Positive(message: 'Duration must be greater than 0')]
        #[Assert\LessThan(value: 86400, message: 'Duration cannot exceed 24 hours')]
        private int $duration,

        #[Assert\Length(
            max: 500,
            maxMessage: 'Cover image URL cannot exceed {{ limit }} characters'
        )]
        private ?string $coverImage = null,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function getTagId(): ?string
    {
        return $this->tagId;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }
}
