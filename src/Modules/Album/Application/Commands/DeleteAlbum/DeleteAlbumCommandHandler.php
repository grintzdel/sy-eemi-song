<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Commands\DeleteAlbum;

use App\Modules\Album\Domain\Exceptions\AlbumNotFoundException;
use App\Modules\Album\Domain\Exceptions\UnauthorizedAlbumAccessException;
use App\Modules\Album\Domain\Repositories\IAlbumRepository;
use App\Modules\Shared\Application\Services\IUserProvider;
use App\Modules\Shared\Domain\ValueObjects\AlbumId;
use App\Modules\Shared\Domain\ValueObjects\UserId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteAlbumCommandHandler
{
    public function __construct(
        private IAlbumRepository $albumRepository,
        private IUserProvider $userProvider,
    ) {
    }

    /**
     * @throws AlbumNotFoundException
     * @throws UnauthorizedAlbumAccessException
     */
    public function __invoke(DeleteAlbumCommand $command): void
    {
        $albumId = new AlbumId($command->getId());
        $album = $this->albumRepository->findById($albumId);

        if (null === $album) {
            throw AlbumNotFoundException::withId($command->getId());
        }

        $currentUserId = new UserId($this->userProvider->getUserId());
        if (!$album->isOwnedBy($currentUserId)) {
            throw UnauthorizedAlbumAccessException::forUser($this->userProvider->getUserId(), $command->getId());
        }

        $this->albumRepository->delete($albumId);
    }
}
