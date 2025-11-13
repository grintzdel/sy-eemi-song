<?php

declare(strict_types=1);

namespace App\Modules\Album\Presentation\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Modules\Album\Application\Queries\ListAlbums\ListAlbumsQuery;
use App\Modules\Album\Presentation\ApiResource\AlbumResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class ListAlbumsProvider implements ProviderInterface
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

        $query = new ListAlbumsQuery($artistId);
        $albumViewModels = $this->handle($query);

        return array_map(
            fn($viewModel) => $this->mapToResource($viewModel),
            $albumViewModels
        );
    }

    private function mapToResource($viewModel): AlbumResource
    {
        $resource = new AlbumResource();
        $resource->id = $viewModel->id;
        $resource->artistId = $viewModel->artistId;
        $resource->name = $viewModel->name;
        $resource->categoryId = $viewModel->categoryId;
        $resource->createdAt = $viewModel->createdAt;
        $resource->updatedAt = $viewModel->updatedAt;
        $resource->deletedAt = $viewModel->deletedAt;

        return $resource;
    }
}
