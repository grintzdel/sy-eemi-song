<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Commands\DeleteSong;

use App\Modules\Shared\Application\Services\IUserProvider;
use App\Modules\Shared\Domain\ValueObjects\SongId;
use App\Modules\Shared\Domain\ValueObjects\UserId;
use App\Modules\Song\Application\ViewModels\IdViewModel;
use App\Modules\Song\Domain\Exceptions\SongNotFoundException;
use App\Modules\Song\Domain\Exceptions\UnauthorizedSongAccessException;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteSongCommandHandler
{
    public function __construct(
        private ISongRepository $songRepository,
        private IUserProvider $userProvider,
    ) {
    }

    /**
     * @throws UnauthorizedSongAccessException
     * @throws SongNotFoundException
     */
    public function __invoke(DeleteSongCommand $command): IdViewModel
    {
        $songId = new SongId($command->getId());
        $song = $this->songRepository->findById($songId);

        if (null === $song) {
            throw SongNotFoundException::withId($command->getId());
        }

        $currentUserId = new UserId($this->userProvider->getUserId());
        if (!$song->isOwnedBy($currentUserId)) {
            throw UnauthorizedSongAccessException::forUser($this->userProvider->getUserId(), $command->getId());
        }

        $song->softDelete();
        $this->songRepository->save($song);

        return new IdViewModel($song->getId()->getValue());
    }
}
