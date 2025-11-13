<?php

declare(strict_types=1);

namespace App\Modules\Album\Presentation\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Modules\Album\Application\Commands\DeleteAlbum\DeleteAlbumCommand;
use App\Modules\Album\Presentation\ApiResource\AlbumResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteAlbumProcessor implements ProcessorInterface
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
        /** @var AlbumResource $data */
        $id = $uriVariables['id'] ?? $data->id;

        $command = new DeleteAlbumCommand(
            id: $id,
            authorId: $data->authorId
        );

        $this->handle($command);
    }
}
