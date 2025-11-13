<?php

declare(strict_types=1);

namespace App\Modules\Song\Presentation\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Modules\Song\Application\Queries\GetSong\GetSongQuery;
use App\Modules\Song\Presentation\ApiResource\SongResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class GetSongProvider implements ProviderInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $queryBus
    )
    {
        $this->messageBus = $queryBus;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?SongResource
    {
        $id = $uriVariables['id'] ?? null;

        if ($id === null) {
            return null;
        }

        $query = new GetSongQuery($id);
        $songViewModel = $this->handle($query);

        return $this->mapToResource($songViewModel);
    }

    private function mapToResource($viewModel): SongResource
    {
        $resource = new SongResource();
        $resource->id = $viewModel->id;
        $resource->artistId = $viewModel->artistId;
        $resource->name = $viewModel->name;
        $resource->categoryId = $viewModel->categoryId;
        $resource->tag = $viewModel->tag;
        $resource->duration = $viewModel->duration;
        $resource->coverImage = $viewModel->coverImage;
        $resource->durationFormatted = $viewModel->durationFormatted;
        $resource->createdAt = $viewModel->createdAt;
        $resource->updatedAt = $viewModel->updatedAt;
        $resource->deletedAt = $viewModel->deletedAt;

        return $resource;
    }
}
