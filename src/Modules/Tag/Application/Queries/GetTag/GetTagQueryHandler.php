<?php

declare(strict_types=1);

namespace App\Modules\Tag\Application\Queries\GetTag;

use App\Modules\Shared\Domain\ValueObjects\TagId;
use App\Modules\Tag\Application\ViewModels\TagViewModel;
use App\Modules\Tag\Domain\Repositories\ITagRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetTagQueryHandler
{
    public function __construct(
        private ITagRepository $tagRepository
    ) {}

    public function __invoke(GetTagQuery $query): TagViewModel
    {
        $tagId = new TagId($query->getId());
        $tag = $this->tagRepository->findById($tagId);

        if ($tag === null) {
            throw new NotFoundHttpException('Tag not found');
        }

        return TagViewModel::fromEntity($tag);
    }
}
