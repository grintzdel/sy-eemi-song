<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Presentation\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Modules\Authentication\Application\Commands\Register\RegisterCommand;
use App\Modules\Authentication\Presentation\ApiResource\AuthResource;
use App\Modules\Shared\Domain\Enums\Roles;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class RegisterProcessor implements ProcessorInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $messageBus
    )
    {
        $this->messageBus = $messageBus;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): AuthResource
    {
        $command = new RegisterCommand(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            role: $data['role'] ?? Roles::ROLE_USER->value
        );

        $viewModel = $this->handle($command);

        return new AuthResource($viewModel);
    }
}
