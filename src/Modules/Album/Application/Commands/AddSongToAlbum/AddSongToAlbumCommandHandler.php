<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Commands\AddSongToAlbum;

use App\Modules\Album\Domain\Exceptions\AlbumNotFoundException;
use App\Modules\Album\Domain\Exceptions\UnauthorizedAlbumAccessException;
use App\Modules\Album\Domain\Repositories\IAlbumRepository;
use App\Modules\Shared\Application\Services\IUserProvider;
use App\Modules\Shared\Domain\ValueObjects\AlbumId;
use App\Modules\Shared\Domain\ValueObjects\SongId;
use App\Modules\Shared\Domain\ValueObjects\UserId;
use App\Modules\Song\Domain\Exceptions\SongNotFoundException;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class AddSongToAlbumCommandHandler
{
    public function __construct(
        private IAlbumRepository $albumRepository,
        private ISongRepository $songRepository,
        private IUserProvider $userProvider,
    ) {
    }

    /**
     * @throws AlbumNotFoundException
     * @throws SongNotFoundException
     * @throws UnauthorizedAlbumAccessException
     */
    public function __invoke(AddSongToAlbumCommand $command): void
    {
        $albumId = new AlbumId($command->getAlbumId());
        $album = $this->albumRepository->findById($albumId);

        if (null === $album) {
            throw AlbumNotFoundException::withId($command->getAlbumId());
        }

        $currentUserId = new UserId($this->userProvider->getUserId());
        if (!$album->isOwnedBy($currentUserId)) {
            throw UnauthorizedAlbumAccessException::forUser($this->userProvider->getUserId(), $command->getAlbumId());
        }

        $songId = new SongId($command->getSongId());
        $song = $this->songRepository->findById($songId);

        if (null === $song) {
            throw SongNotFoundException::withId($command->getSongId());
        }

        $this->albumRepository->addSongToAlbum($albumId, $songId);
    }
}
