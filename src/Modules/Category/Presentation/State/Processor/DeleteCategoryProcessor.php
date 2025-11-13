<?php

declare(strict_types=1);

namespace App\Modules\Category\Presentation\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Modules\Category\Application\Commands\DeleteCategory\DeleteCategoryCommand;
use App\Modules\Category\Presentation\ApiResource\CategoryResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteCategoryProcessor implements ProcessorInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $commandBus
    )
    {
        $this->messageBus = $commandBus;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        /** @var CategoryResource $data */
        $id = $uriVariables['id'] ?? $data->id;

        $command = new DeleteCategoryCommand(id: $id);

        $this->handle($command);
    }
}
