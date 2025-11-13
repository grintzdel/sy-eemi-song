<?php

declare(strict_types=1);

namespace App\Modules\Category\Application\Queries\ListCategories;

final readonly class ListCategoriesQuery
{
    public function __construct(
        private bool $includeDeleted = false
    ) {}

    public function isIncludeDeleted(): bool
    {
        return $this->includeDeleted;
    }
}
