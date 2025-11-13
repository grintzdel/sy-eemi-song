<?php

declare(strict_types=1);

namespace App\Modules\Category\Presentation\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Modules\Category\Application\Commands\UpdateCategory\UpdateCategoryCommand;
use App\Modules\Category\Presentation\ApiResource\CategoryResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpdateCategoryProcessor implements ProcessorInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $commandBus
    )
    {
        $this->messageBus = $commandBus;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CategoryResource
    {
        /** @var CategoryResource $data */
        $id = $uriVariables['id'] ?? $data->id;

        $command = new UpdateCategoryCommand(
            id: $id,
            name: $data->name,
            description: $data->description
        );

        $viewModel = $this->handle($command);

        $resource = new CategoryResource();
        $resource->id = $viewModel->id;
        $resource->name = $viewModel->name;
        $resource->description = $viewModel->description;
        $resource->createdAt = $viewModel->createdAt;
        $resource->updatedAt = $viewModel->updatedAt;
        $resource->deletedAt = $viewModel->deletedAt;

        return $resource;
    }
}
