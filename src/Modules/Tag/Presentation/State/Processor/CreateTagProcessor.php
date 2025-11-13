<?php

declare(strict_types=1);

namespace App\Modules\Tag\Presentation\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Modules\Tag\Application\Commands\CreateTag\CreateTagCommand;
use App\Modules\Tag\Presentation\ApiResource\TagResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateTagProcessor implements ProcessorInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $commandBus
    )
    {
        $this->messageBus = $commandBus;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): TagResource
    {
        /** @var TagResource $data */
        $command = new CreateTagCommand(
            name: $data->name
        );

        $viewModel = $this->handle($command);

        $resource = new TagResource();
        $resource->id = $viewModel->id;
        $resource->name = $viewModel->name;
        $resource->createdAt = $viewModel->createdAt;
        $resource->updatedAt = $viewModel->updatedAt;

        return $resource;
    }
}
