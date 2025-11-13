<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Commands\RemoveSongFromAlbum;

use App\Modules\Album\Domain\Exceptions\AlbumNotFoundException;
use App\Modules\Album\Domain\Exceptions\UnauthorizedAlbumAccessException;
use App\Modules\Album\Domain\Repositories\IAlbumRepository;
use App\Modules\Album\Domain\ValueObjects\AlbumId;
use App\Modules\Shared\Domain\ValueObjects\SongId;
use App\Modules\Shared\Domain\ValueObjects\UserId;
use App\Modules\Song\Domain\Exceptions\SongNotFoundException;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class RemoveSongFromAlbumCommandHandler
{
    public function __construct(
        private IAlbumRepository $albumRepository,
        private ISongRepository $songRepository
    ) {}

    /**
     * @throws AlbumNotFoundException
     * @throws SongNotFoundException
     * @throws UnauthorizedAlbumAccessException
     */
    public function __invoke(RemoveSongFromAlbumCommand $command): void
    {
        $albumId = new AlbumId($command->getAlbumId());
        $album = $this->albumRepository->findById($albumId);

        if ($album === null) {
            throw AlbumNotFoundException::withId($command->getAlbumId());
        }

        $requestingUserId = new UserId($command->getArtistId());
        if (!$album->isOwnedBy($requestingUserId)) {
            throw UnauthorizedAlbumAccessException::forUser(
                $command->getArtistId(),
                $command->getAlbumId()
            );
        }

        $songId = new SongId($command->getSongId());
        $song = $this->songRepository->findById($songId);

        if ($song === null) {
            throw SongNotFoundException::withId($command->getSongId());
        }

        $this->albumRepository->removeSongFromAlbum($albumId, $songId);
    }
}
