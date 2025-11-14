<?php

declare(strict_types=1);

namespace App\Modules\User\Presentation\Controllers;

use App\Modules\Shared\Presentation\Controllers\AppController;
use App\Modules\User\Application\Commands\CreateUser\CreateUserCommand;
use App\Modules\User\Application\Commands\UpdateUser\UpdateUserCommand;
use App\Modules\User\Application\Queries\GetUser\GetUserQuery;
use App\Modules\User\Application\Queries\GetUserByEmail\GetUserByEmailQuery;
use App\Modules\User\Application\Queries\ListUsers\ListUsersQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/users', format: 'json')]
class UserController extends AppController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN', message: 'Only admins and moderators can list users')]
    #[IsGranted('ROLE_MODERATOR', message: 'Only admins and moderators can list users')]
    public function listUsers(): JsonResponse
    {
        return $this->dispatchQuery(new ListUsersQuery());
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{id}', methods: ['GET'])]
    #[IsGranted('ROLE_USER', message: 'You must be authenticated to view user details')]
    public function getUserById(string $id): JsonResponse
    {
        return $this->dispatchQuery(new GetUserQuery($id));
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/email/{email}', methods: ['GET'])]
    public function getUserByEmail(string $email): JsonResponse
    {
        return $this->dispatchQuery(new GetUserByEmailQuery($email));
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'Only admins can create users')]
    public function createUser(#[MapRequestPayload] CreateUserCommand $command): JsonResponse
    {
        return $this->dispatch($command);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{id}', methods: ['PUT'])]
    #[IsGranted('ROLE_ADMIN', message: 'Only admins or the user themselves can update user details')]
    public function updateUser(string $id, #[MapRequestPayload] UpdateUserCommand $command): JsonResponse
    {
        return $this->dispatch($command);
    }
}
