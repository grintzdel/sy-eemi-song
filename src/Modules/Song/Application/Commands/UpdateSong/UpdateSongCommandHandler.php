<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Commands\UpdateSong;

use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use App\Modules\Song\Application\ViewModels\SongViewModel;
use App\Modules\Song\Domain\Exceptions\InvalidDurationException;
use App\Modules\Song\Domain\Exceptions\InvalidSongNameException;
use App\Modules\Song\Domain\Exceptions\SongNotFoundException;
use App\Modules\Song\Domain\Exceptions\UnauthorizedSongAccessException;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use App\Modules\Song\Domain\ValueObjects\SongDuration;
use App\Modules\Song\Domain\ValueObjects\SongId;
use App\Modules\Song\Domain\ValueObjects\SongName;
use App\Modules\Song\Domain\ValueObjects\Tag;
use App\Modules\Song\Domain\ValueObjects\UserId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UpdateSongCommandHandler
{
    public function __construct(
        private ISongRepository $songRepository
    )
    {
    }

    /**
     * @throws InvalidSongNameException
     * @throws UnauthorizedSongAccessException
     * @throws InvalidDurationException
     * @throws SongNotFoundException
     */
    public function __invoke(UpdateSongCommand $command): SongViewModel
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

        $song->update(
            name: new SongName($command->getName()),
            categoryId: new CategoryId($command->getCategoryId()),
            tag: new Tag($command->getTag()),
            duration: new SongDuration($command->getDuration())
        );

        $this->songRepository->save($song);

        return SongViewModel::fromEntity($song);
    }
}
