<?php

declare(strict_types=1);

namespace App\Modules\Category\Application\Commands\UpdateCategory;

use App\Modules\Category\Application\ViewModels\CategoryViewModel;
use App\Modules\Category\Domain\Exceptions\CategoryNotFoundException;
use App\Modules\Category\Domain\Exceptions\DuplicateCategoryNameException;
use App\Modules\Category\Domain\Exceptions\InvalidCategoryNameException;
use App\Modules\Category\Domain\Repositories\ICategoryRepository;
use App\Modules\Category\Domain\ValueObjects\CategoryName;
use App\Modules\Category\Domain\ValueObjects\CategoryDescription;
use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UpdateCategoryCommandHandler
{
    public function __construct(
        private ICategoryRepository $categoryRepository
    ) {}

    /**
     * @throws CategoryNotFoundException
     * @throws InvalidCategoryNameException
     * @throws DuplicateCategoryNameException
     */
    public function __invoke(UpdateCategoryCommand $command): CategoryViewModel
    {
        $categoryId = new CategoryId($command->getId());
        $category = $this->categoryRepository->findById($categoryId);

        if ($category === null) {
            throw CategoryNotFoundException::withId($command->getId());
        }

        $newName = new CategoryName($command->getName());

        if ($newName->getValue() !== $category->getName()->getValue()) {
            if ($this->categoryRepository->exists($newName)) {
                throw DuplicateCategoryNameException::withName($command->getName());
            }
        }

        $category->update(
            name: $newName,
            description: new CategoryDescription($command->getDescription())
        );

        $this->categoryRepository->save($category);

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
