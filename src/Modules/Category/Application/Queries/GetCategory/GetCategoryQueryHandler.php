<?php

declare(strict_types=1);

namespace App\Modules\Category\Application\Queries\GetCategory;

use App\Modules\Category\Application\ViewModels\CategoryViewModel;
use App\Modules\Category\Domain\Exceptions\CategoryNotFoundException;
use App\Modules\Category\Domain\Repositories\ICategoryRepository;
use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetCategoryQueryHandler
{
    public function __construct(
        private ICategoryRepository $categoryRepository
    ) {}

    /**
     * @throws CategoryNotFoundException
     */
    public function __invoke(GetCategoryQuery $query): CategoryViewModel
    {
        $categoryId = new CategoryId($query->getId());
        $category = $this->categoryRepository->findById($categoryId);

        if ($category === null) {
            throw CategoryNotFoundException::withId($query->getId());
        }

        return new CategoryViewModel(
            id: $category->getId()->getValue(),
            name: $category->getName()->getValue(),
            description: $category->getDescription()->getValue(),
            createdAt: $category->getCreatedAt(),
            updatedAt: $category->getUpdatedAt(),
            deletedAt: $category->getDeletedAt()
        );
    }
}
