<?php

declare(strict_types=1);

namespace App\Modules\Category\Application\Queries\ListCategories;

use App\Modules\Category\Application\ViewModels\CategoryViewModel;
use App\Modules\Category\Domain\Repositories\ICategoryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ListCategoriesQueryHandler
{
    public function __construct(
        private ICategoryRepository $categoryRepository
    ) {}

    public function __invoke(ListCategoriesQuery $query): array
    {
        $categories = $query->isIncludeDeleted()
            ? $this->categoryRepository->findAll()
            : $this->categoryRepository->findAllActive();

        return array_map(
            fn($category) => new CategoryViewModel(
                id: $category->getId()->getValue(),
                name: $category->getName()->getValue(),
                description: $category->getDescription()->getValue(),
                createdAt: $category->getCreatedAt(),
                updatedAt: $category->getUpdatedAt(),
                deletedAt: $category->getDeletedAt()
            ),
            $categories
        );
    }
}
