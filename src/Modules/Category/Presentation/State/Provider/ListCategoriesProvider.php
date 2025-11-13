<?php

declare(strict_types=1);

namespace App\Modules\Category\Presentation\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Modules\Category\Application\Queries\ListCategories\ListCategoriesQuery;
use App\Modules\Category\Presentation\ApiResource\CategoryResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class ListCategoriesProvider implements ProviderInterface
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
        $query = new ListCategoriesQuery(includeDeleted: false);
        $viewModels = $this->handle($query);

        return array_map(function ($viewModel) {
            $resource = new CategoryResource();
            $resource->id = $viewModel->id;
            $resource->name = $viewModel->name;
            $resource->description = $viewModel->description;
            $resource->createdAt = $viewModel->createdAt;
            $resource->updatedAt = $viewModel->updatedAt;
            $resource->deletedAt = $viewModel->deletedAt;

            return $resource;
        }, $viewModels);
    }
}
