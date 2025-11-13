<?php

declare(strict_types=1);

namespace App\Modules\Category\Application\Queries\GetCategory;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class GetCategoryQuery
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
