<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Commands\AddSongToAlbum;

use App\Modules\Album\Domain\Exceptions\AlbumNotFoundException;
use App\Modules\Album\Domain\Exceptions\UnauthorizedAlbumAccessException;
use App\Modules\Album\Domain\Repositories\IAlbumRepository;
use App\Modules\Album\Domain\ValueObjects\AlbumId;
use App\Modules\Shared\Domain\ValueObjects\UserId;
use App\Modules\Song\Domain\Exceptions\SongNotFoundException;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use App\Modules\Song\Domain\ValueObjects\SongId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class AddSongToAlbumCommandHandler
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
    public function __invoke(AddSongToAlbumCommand $command): void
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

        $this->albumRepository->addSongToAlbum($albumId, $songId);
    }
}
