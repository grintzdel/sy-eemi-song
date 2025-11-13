<?php

declare(strict_types=1);

namespace App\Modules\Category\Application\Commands\DeleteCategory;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class DeleteCategoryCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'Category ID is required')]
        #[Assert\Uuid(message: 'Category ID must be a valid UUID')]
        private string $id
    ) {}

    public function getId(): string
    {
        return $this->id;
    }
}
