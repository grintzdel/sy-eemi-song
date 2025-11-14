<?php

declare(strict_types=1);

namespace App\Modules\Tag\Presentation\Controllers;

use App\Modules\Shared\Presentation\Controllers\AppController;
use App\Modules\Tag\Application\Commands\CreateTag\CreateTagCommand;
use App\Modules\Tag\Application\Commands\DeleteTag\DeleteTagCommand;
use App\Modules\Tag\Application\Commands\UpdateTag\UpdateTagCommand;
use App\Modules\Tag\Application\Queries\GetTag\GetTagQuery;
use App\Modules\Tag\Application\Queries\ListTags\ListTagsQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/tags', format: 'json')]
class TagController extends AppController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('', methods: ['GET'])]
    public function listTags(): JsonResponse
    {
        return $this->dispatchQuery(new ListTagsQuery());
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{id}', methods: ['GET'])]
    public function getTag(string $id): JsonResponse
    {
        return $this->dispatchQuery(new GetTagQuery($id));
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'Only admins and moderators can create tags')]
    #[IsGranted('ROLE_MODERATOR', message: 'Only admins and moderators can create tags')]
    public function createTag(#[MapRequestPayload] CreateTagCommand $command): JsonResponse
    {
        return $this->dispatch($command);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{id}', methods: ['PUT'])]
    #[IsGranted('ROLE_ADMIN', message: 'Only admins and moderators can update tags')]
    #[IsGranted('ROLE_MODERATOR', message: 'Only admins and moderators can update tags')]
    public function updateTag(string $id, #[MapRequestPayload] UpdateTagCommand $command): JsonResponse
    {
        return $this->dispatch($command);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{id}', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'Only admins and moderators can delete tags')]
    #[IsGranted('ROLE_MODERATOR', message: 'Only admins and moderators can delete tags')]
    public function deleteTag(string $id): JsonResponse
    {
        return $this->dispatch(new DeleteTagCommand($id));
    }
}
