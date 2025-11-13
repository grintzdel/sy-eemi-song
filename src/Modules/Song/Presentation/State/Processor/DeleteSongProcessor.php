<?php

declare(strict_types=1);

namespace App\Modules\Song\Presentation\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Modules\Song\Application\Commands\DeleteSong\DeleteSongCommand;
use App\Modules\Song\Presentation\ApiResource\SongResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteSongProcessor implements ProcessorInterface
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
        /** @var SongResource $data */
        $id = $uriVariables['id'] ?? $data->id;

        $command = new DeleteSongCommand(
            id: $id,
            artistId: $data->artistId
        );

        $this->handle($command);
    }
}
