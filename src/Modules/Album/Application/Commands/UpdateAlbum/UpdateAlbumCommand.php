<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Commands\UpdateAlbum;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateAlbumCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'Album ID is required')]
        #[Assert\Uuid(message: 'Album ID must be a valid UUID')]
        private string $id,

        #[Assert\NotBlank(message: 'Author ID is required')]
        #[Assert\Uuid(message: 'Author ID must be a valid UUID')]
        private string $authorId,

        #[Assert\NotBlank(message: 'Album name is required')]
        #[Assert\Length(
            max: 255,
            maxMessage: 'Album name cannot exceed {{ limit }} characters'
        )]
        private string $name,

        #[Assert\Uuid(message: 'Category ID must be a valid UUID')]
        private ?string $categoryId = null
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
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
