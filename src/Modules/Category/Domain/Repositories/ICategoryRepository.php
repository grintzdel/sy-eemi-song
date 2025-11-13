<?php

declare(strict_types=1);

namespace App\Modules\Category\Domain\Repositories;

use App\Modules\Category\Domain\Entities\Category;
use App\Modules\Category\Domain\ValueObjects\CategoryName;
use App\Modules\Shared\Domain\ValueObjects\CategoryId;

interface ICategoryRepository
{
    /*
     * Queries
     */
    public function findById(CategoryId $id): ?Category;

    public function findByName(CategoryName $name): ?Category;

    public function findAll(): array;

    public function findAllActive(): array;


    /*
     * Commands
     */
    public function save(Category $category): void;

    public function delete(CategoryId $id): void;

    public function exists(CategoryName $name): bool;
}
