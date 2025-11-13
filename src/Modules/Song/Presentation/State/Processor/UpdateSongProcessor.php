<?php

declare(strict_types=1);

namespace App\Modules\Song\Presentation\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Modules\Song\Application\Commands\UpdateSong\UpdateSongCommand;
use App\Modules\Song\Presentation\ApiResource\SongResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpdateSongProcessor implements ProcessorInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $commandBus
    )
    {
        $this->messageBus = $commandBus;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): SongResource
    {
        /** @var SongResource $data */
        $id = $uriVariables['id'] ?? $data->id;

        $command = new UpdateSongCommand(
            id: $id,
            artistId: $data->artistId,
            name: $data->name,
            categoryId: $data->categoryId,
            tag: $data->tag,
            duration: $data->duration,
            coverImage: $data->coverImage
        );

        $songViewModel = $this->handle($command);

        $data->id = $songViewModel->id;
        $data->artistId = $songViewModel->artistId;
        $data->name = $songViewModel->name;
        $data->categoryId = $songViewModel->categoryId;
        $data->tag = $songViewModel->tag;
        $data->duration = $songViewModel->duration;
        $data->coverImage = $songViewModel->coverImage;
        $data->durationFormatted = $songViewModel->durationFormatted;
        $data->createdAt = $songViewModel->createdAt;
        $data->updatedAt = $songViewModel->updatedAt;
        $data->deletedAt = $songViewModel->deletedAt;

        return $data;
    }
}
