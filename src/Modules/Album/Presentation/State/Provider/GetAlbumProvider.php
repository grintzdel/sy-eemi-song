<?php

declare(strict_types=1);

namespace App\Modules\Album\Presentation\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Modules\Album\Application\Queries\GetAlbum\GetAlbumQuery;
use App\Modules\Album\Presentation\ApiResource\AlbumResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class GetAlbumProvider implements ProviderInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $queryBus
    )
    {
        $this->messageBus = $queryBus;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?AlbumResource
    {
        $id = $uriVariables['id'] ?? null;

        if ($id === null) {
            return null;
        }

        $query = new GetAlbumQuery($id);
        $albumViewModel = $this->handle($query);

        return $this->mapToResource($albumViewModel);
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
