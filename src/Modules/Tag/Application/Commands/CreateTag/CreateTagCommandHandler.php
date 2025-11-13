<?php

declare(strict_types=1);

namespace App\Modules\Tag\Application\Commands\CreateTag;

use App\Modules\Tag\Application\ViewModels\TagViewModel;
use App\Modules\Tag\Domain\Entities\Tag;
use App\Modules\Tag\Domain\Repositories\ITagRepository;
use App\Modules\Tag\Domain\ValueObjects\TagName;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateTagCommandHandler
{
    public function __construct(
        private ITagRepository $tagRepository
    ) {}

    public function __invoke(CreateTagCommand $command): TagViewModel
    {
        $tag = Tag::create(
            name: new TagName($command->getName())
        );

        $this->tagRepository->save($tag);

        return TagViewModel::fromEntity($tag);
    }
}
