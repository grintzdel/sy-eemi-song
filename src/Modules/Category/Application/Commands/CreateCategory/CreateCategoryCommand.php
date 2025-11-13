<?php

declare(strict_types=1);

namespace App\Modules\Category\Application\Commands\CreateCategory;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateCategoryCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'Category name is required')]
        #[Assert\Length(max: 100, maxMessage: 'Category name cannot exceed 100 characters')]
        private string $name,

        #[Assert\Length(max: 500, maxMessage: 'Description cannot exceed 500 characters')]
        private ?string $description = null
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
