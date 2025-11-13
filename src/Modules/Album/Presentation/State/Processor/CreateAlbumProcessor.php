<?php

declare(strict_types=1);

namespace App\Modules\Album\Presentation\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Modules\Album\Application\Commands\CreateAlbum\CreateAlbumCommand;
use App\Modules\Album\Presentation\ApiResource\AlbumResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateAlbumProcessor implements ProcessorInterface
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
        $command = new CreateAlbumCommand(
            artistId: $data->artistId,
            name: $data->name,
            categoryId: $data->categoryId
        );

        $albumViewModel = $this->handle($command);

        $data->id = $albumViewModel->id;
        $data->artistId = $albumViewModel->artistId;
        $data->name = $albumViewModel->name;
        $data->categoryId = $albumViewModel->categoryId;
        $data->createdAt = $albumViewModel->createdAt;
        $data->updatedAt = $albumViewModel->updatedAt;
        $data->deletedAt = $albumViewModel->deletedAt;

        return $data;
    }
}
