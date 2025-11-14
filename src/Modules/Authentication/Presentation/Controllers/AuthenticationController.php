<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Presentation\Controllers;

use App\Modules\Authentication\Application\Commands\Login\LoginCommand;
use App\Modules\Authentication\Application\Commands\Register\RegisterCommand;
use App\Modules\Shared\Presentation\Controllers\AppController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/auth', format: 'json')]
class AuthenticationController extends AppController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('/register', methods: ['POST'])]
    public function register(#[MapRequestPayload] RegisterCommand $command): JsonResponse
    {
        return $this->dispatch($command);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/login', methods: ['POST'])]
    public function login(#[MapRequestPayload] LoginCommand $command): JsonResponse
    {
        return $this->dispatch($command);
    }
}
