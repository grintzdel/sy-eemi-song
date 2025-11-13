<?php

declare(strict_types=1);

namespace App\Modules\Tag\Presentation\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Modules\Tag\Application\Commands\DeleteTag\DeleteTagCommand;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteTagProcessor implements ProcessorInterface
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
        $id = $uriVariables['id'] ?? null;

        $command = new DeleteTagCommand(id: $id);

        $this->handle($command);
    }
}
