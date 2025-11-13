<?php

declare(strict_types=1);

namespace App\Modules\Tag\Application\Queries\ListTags;

use App\Modules\Tag\Application\ViewModels\TagViewModel;
use App\Modules\Tag\Domain\Repositories\ITagRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ListTagsQueryHandler
{
    public function __construct(
        private ITagRepository $tagRepository
    ) {}

    public function __invoke(ListTagsQuery $query): array
    {
        $tags = $this->tagRepository->findAll();

        return array_map(
            fn($tag) => TagViewModel::fromEntity($tag),
            $tags
        );
    }
}
