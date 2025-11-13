<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Commands\DeleteAlbum;

use App\Modules\Album\Domain\Exceptions\AlbumNotFoundException;
use App\Modules\Album\Domain\Exceptions\UnauthorizedAlbumAccessException;
use App\Modules\Album\Domain\Repositories\IAlbumRepository;
use App\Modules\Album\Domain\ValueObjects\AlbumId;
use App\Modules\Song\Domain\ValueObjects\UserId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteAlbumCommandHandler
{
    public function __construct(
        private IAlbumRepository $albumRepository
    ) {}

    /**
     * @throws AlbumNotFoundException
     * @throws UnauthorizedAlbumAccessException
     */
    public function __invoke(DeleteAlbumCommand $command): void
    {
        $albumId = new AlbumId($command->getId());
        $album = $this->albumRepository->findById($albumId);

        if ($album === null) {
            throw AlbumNotFoundException::withId($command->getId());
        }

        $requestingUserId = new UserId($command->getAuthorId());
        if (!$album->isOwnedBy($requestingUserId)) {
            throw UnauthorizedAlbumAccessException::forUser(
                $command->getAuthorId(),
                $command->getId()
            );
        }

        $this->albumRepository->delete($albumId);
    }
}
