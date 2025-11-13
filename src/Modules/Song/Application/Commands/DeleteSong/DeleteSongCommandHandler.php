<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Commands\DeleteSong;

use App\Modules\Song\Application\ViewModels\IdViewModel;
use App\Modules\Song\Domain\Exceptions\SongNotFoundException;
use App\Modules\Song\Domain\Exceptions\UnauthorizedSongAccessException;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use App\Modules\Song\Domain\ValueObjects\SongId;
use App\Modules\Song\Domain\ValueObjects\UserId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteSongCommandHandler
{
    public function __construct(
        private ISongRepository $songRepository
    )
    {
    }

    /**
     * @throws UnauthorizedSongAccessException
     * @throws SongNotFoundException
     */
    public function __invoke(DeleteSongCommand $command): IdViewModel
    {
        $songId = new SongId($command->getId());
        $song = $this->songRepository->findById($songId);

        if ($song === null) {
            throw SongNotFoundException::withId($command->getId());
        }

        $requestingUserId = new UserId($command->getArtistId());
        if (!$song->isOwnedBy($requestingUserId)) {
            throw UnauthorizedSongAccessException::forUser(
                $command->getArtistId(),
                $command->getId()
            );
        }

        $song->softDelete();
        $this->songRepository->save($song);

        return new IdViewModel($song->getId()->getValue());
    }
}
