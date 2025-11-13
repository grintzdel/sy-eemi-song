<?php

declare(strict_types=1);

namespace App\Modules\Tag\Application\Commands\UpdateTag;

use App\Modules\Shared\Domain\ValueObjects\TagId;
use App\Modules\Tag\Application\ViewModels\TagViewModel;
use App\Modules\Tag\Domain\Repositories\ITagRepository;
use App\Modules\Tag\Domain\ValueObjects\TagName;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsMessageHandler]
final readonly class UpdateTagCommandHandler
{
    public function __construct(
        private ITagRepository $tagRepository
    ) {}

    public function __invoke(UpdateTagCommand $command): TagViewModel
    {
        $tagId = new TagId($command->getId());
        $tag = $this->tagRepository->findById($tagId);

        if ($tag === null) {
            throw new NotFoundHttpException('Tag not found');
        }

        $tag->update(
            name: new TagName($command->getName())
        );

        $this->tagRepository->save($tag);

        return TagViewModel::fromEntity($tag);
    }
}
