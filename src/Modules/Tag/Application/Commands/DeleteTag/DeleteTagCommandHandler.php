<?php

declare(strict_types=1);

namespace App\Modules\Tag\Application\Commands\DeleteTag;

use App\Modules\Shared\Domain\ValueObjects\TagId;
use App\Modules\Tag\Domain\Repositories\ITagRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsMessageHandler]
final readonly class DeleteTagCommandHandler
{
    public function __construct(
        private ITagRepository $tagRepository
    ) {}

    public function __invoke(DeleteTagCommand $command): void
    {
        $tagId = new TagId($command->getId());
        $tag = $this->tagRepository->findById($tagId);

        if ($tag === null) {
            throw new NotFoundHttpException('Tag not found');
        }

        $tag->delete();
        $this->tagRepository->save($tag);
    }
}
