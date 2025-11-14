<?php

declare(strict_types=1);

namespace App\Modules\Category\Presentation\Controllers;

use App\Modules\Category\Application\Commands\CreateCategory\CreateCategoryCommand;
use App\Modules\Category\Application\Commands\DeleteCategory\DeleteCategoryCommand;
use App\Modules\Category\Application\Commands\UpdateCategory\UpdateCategoryCommand;
use App\Modules\Category\Application\Queries\GetCategory\GetCategoryQuery;
use App\Modules\Category\Application\Queries\ListCategories\ListCategoriesQuery;
use App\Modules\Shared\Presentation\Controllers\AppController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/categories', format: 'json')]
class CategoryController extends AppController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('', methods: ['GET'])]
    public function listCategories(): JsonResponse
    {
        return $this->dispatchQuery(new ListCategoriesQuery());
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{id}', methods: ['GET'])]
    public function getCategory(string $id): JsonResponse
    {
        return $this->dispatchQuery(new GetCategoryQuery($id));
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'Only admins and moderators can create categories')]
    #[IsGranted('ROLE_MODERATOR', message: 'Only admins and moderators can create categories')]
    public function createCategory(#[MapRequestPayload] CreateCategoryCommand $command): JsonResponse
    {
        return $this->dispatch($command);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{id}', methods: ['PUT'])]
    #[IsGranted('ROLE_ADMIN', message: 'Only admins and moderators can update categories')]
    #[IsGranted('ROLE_MODERATOR', message: 'Only admins and moderators can update categories')]
    public function updateCategory(string $id, #[MapRequestPayload] UpdateCategoryCommand $command): JsonResponse
    {
        return $this->dispatch($command);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{id}', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'Only admins and moderators can delete categories')]
    #[IsGranted('ROLE_MODERATOR', message: 'Only admins and moderators can delete categories')]
    public function deleteCategory(string $id): JsonResponse
    {
        return $this->dispatch(new DeleteCategoryCommand($id));
    }
}
