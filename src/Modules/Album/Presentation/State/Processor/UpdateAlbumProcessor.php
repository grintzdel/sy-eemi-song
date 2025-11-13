<?php

declare(strict_types=1);

namespace App\Modules\Album\Presentation\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Modules\Album\Application\Commands\UpdateAlbum\UpdateAlbumCommand;
use App\Modules\Album\Presentation\ApiResource\AlbumResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpdateAlbumProcessor implements ProcessorInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $commandBus
    )
    {
        $this->messageBus = $commandBus;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): AlbumResource
    {
        /** @var AlbumResource $data */
        $id = $uriVariables['id'] ?? $data->id;

        $command = new UpdateAlbumCommand(
            id: $id,
            authorId: $data->authorId,
            name: $data->name
        );

        $albumViewModel = $this->handle($command);

        $data->id = $albumViewModel->id;
        $data->authorId = $albumViewModel->authorId;
        $data->name = $albumViewModel->name;
        $data->createdAt = $albumViewModel->createdAt;
        $data->updatedAt = $albumViewModel->updatedAt;
        $data->deletedAt = $albumViewModel->deletedAt;

        return $data;
    }
}
