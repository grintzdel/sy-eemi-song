<?php

declare(strict_types=1);

namespace App\Modules\Category\Application\Commands\DeleteCategory;

use App\Modules\Category\Domain\Exceptions\CategoryNotFoundException;
use App\Modules\Category\Domain\Repositories\ICategoryRepository;
use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteCategoryCommandHandler
{
    public function __construct(
        private ICategoryRepository $categoryRepository
    ) {}

    /**
     * @throws CategoryNotFoundException
     */
    public function __invoke(DeleteCategoryCommand $command): void
    {
        $categoryId = new CategoryId($command->getId());
        $category = $this->categoryRepository->findById($categoryId);

        if ($category === null) {
            throw CategoryNotFoundException::withId($command->getId());
        }

        $category->softDelete();
        $this->categoryRepository->save($category);
    }
}
