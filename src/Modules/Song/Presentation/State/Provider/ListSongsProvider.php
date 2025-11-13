<?php

declare(strict_types=1);

namespace App\Modules\Song\Presentation\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Modules\Song\Application\Queries\ListSongs\ListSongsQuery;
use App\Modules\Song\Presentation\ApiResource\SongResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class ListSongsProvider implements ProviderInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $queryBus
    )
    {
        $this->messageBus = $queryBus;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $filters = $context['filters'] ?? [];
        $artistId = $filters['artistId'] ?? null;
        $category = $filters['category'] ?? null;

        $query = new ListSongsQuery($artistId, $category);
        $songViewModels = $this->handle($query);

        return array_map(
            fn($viewModel) => $this->mapToResource($viewModel),
            $songViewModels
        );
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
