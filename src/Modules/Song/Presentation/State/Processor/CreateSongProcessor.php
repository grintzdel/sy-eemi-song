<?php

declare(strict_types=1);

namespace App\Modules\Song\Presentation\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Modules\Song\Application\Commands\CreateSong\CreateSongCommand;
use App\Modules\Song\Presentation\ApiResource\SongResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateSongProcessor implements ProcessorInterface
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
        $command = new CreateSongCommand(
            artistId: $data->artistId,
            name: $data->name,
            category: $data->category,
            album: $data->album,
            tag: $data->tag,
            duration: $data->duration
        );

        $idViewModel = $this->handle($command);

        $data->id = $idViewModel->id;

        return $data;
    }
}
