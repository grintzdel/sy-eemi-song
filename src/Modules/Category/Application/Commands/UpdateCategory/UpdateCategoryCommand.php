<?php

declare(strict_types=1);

namespace App\Modules\Category\Application\Commands\UpdateCategory;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateCategoryCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'Category ID is required')]
        #[Assert\Uuid(message: 'Category ID must be a valid UUID')]
        private string $id,

        #[Assert\NotBlank(message: 'Category name is required')]
        #[Assert\Length(max: 100, maxMessage: 'Category name cannot exceed 100 characters')]
        private string $name,

        #[Assert\Length(max: 500, maxMessage: 'Description cannot exceed 500 characters')]
        private ?string $description = null
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
