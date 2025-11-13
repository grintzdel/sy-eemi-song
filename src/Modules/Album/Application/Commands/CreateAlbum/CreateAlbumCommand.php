<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Commands\CreateAlbum;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateAlbumCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'Artist ID is required')]
        #[Assert\Uuid(message: 'Artist ID must be a valid UUID')]
        private string $artistId,

        #[Assert\NotBlank(message: 'Album name is required')]
        #[Assert\Length(
            max: 255,
            maxMessage: 'Album name cannot exceed {{ limit }} characters'
        )]
        private string $name,

        #[Assert\Uuid(message: 'Category ID must be a valid UUID')]
        private ?string $categoryId = null
    ) {}

    public function getArtistId(): string
    {
        return $this->artistId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }
}
