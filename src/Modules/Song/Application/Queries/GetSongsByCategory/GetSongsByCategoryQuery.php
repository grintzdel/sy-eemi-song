<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Queries\GetSongsByCategory;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class GetSongsByCategoryQuery
{
    #[Assert\NotBlank(message: 'Category ID is required')]
    #[Assert\Uuid(message: 'Category ID must be a valid UUID')]
    private string $categoryId;

    public function __construct(string $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }
}
