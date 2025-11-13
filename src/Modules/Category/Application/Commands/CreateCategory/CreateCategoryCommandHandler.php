<?php

declare(strict_types=1);

namespace App\Modules\Category\Application\Commands\CreateCategory;

use App\Modules\Category\Application\ViewModels\CategoryViewModel;
use App\Modules\Category\Domain\Entities\Category;
use App\Modules\Category\Domain\Exceptions\DuplicateCategoryNameException;
use App\Modules\Category\Domain\Exceptions\InvalidCategoryNameException;
use App\Modules\Category\Domain\Repositories\ICategoryRepository;
use App\Modules\Category\Domain\ValueObjects\CategoryName;
use App\Modules\Category\Domain\ValueObjects\CategoryDescription;
use App\Modules\Shared\Application\Ports\Services\IIdProvider;
use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateCategoryCommandHandler
{
    public function __construct(
        private ICategoryRepository $categoryRepository,
        private IIdProvider $idProvider
    ) {}

    /**
     * @throws InvalidCategoryNameException
     * @throws DuplicateCategoryNameException
     */
    public function __invoke(CreateCategoryCommand $command): CategoryViewModel
    {
        $name = new CategoryName($command->getName());

        if ($this->categoryRepository->exists($name)) {
            throw DuplicateCategoryNameException::withName($command->getName());
        }

        $category = Category::create(
            id: new CategoryId($this->idProvider->generateId()),
            name: $name,
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
