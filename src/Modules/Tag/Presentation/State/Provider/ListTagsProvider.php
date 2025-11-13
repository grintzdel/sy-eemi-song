<?php

declare(strict_types=1);

namespace App\Modules\Tag\Presentation\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Modules\Tag\Application\Queries\ListTags\ListTagsQuery;
use App\Modules\Tag\Presentation\ApiResource\TagResource;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class ListTagsProvider implements ProviderInterface
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
        $query = new ListTagsQuery();
        $viewModels = $this->handle($query);

        return array_map(function ($viewModel) {
            $resource = new TagResource();
            $resource->id = $viewModel->id;
            $resource->name = $viewModel->name;
            $resource->createdAt = $viewModel->createdAt;
            $resource->updatedAt = $viewModel->updatedAt;

            return $resource;
        }, $viewModels);
    }
}
