<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Queries\GetSong;

use App\Modules\Shared\Domain\ValueObjects\SongId;
use App\Modules\Song\Application\ViewModels\SongViewModel;
use App\Modules\Song\Domain\Exceptions\SongNotFoundException;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetSongQueryHandler
{
    public function __construct(
        private ISongRepository $songRepository
    ) {}

    /**
     * @throws SongNotFoundException
     */
    public function __invoke(GetSongQuery $query): SongViewModel
    {
        $songId = new SongId($query->getId());
        $song = $this->songRepository->findById($songId);

        if ($song === null) {
            throw SongNotFoundException::withId($query->getId());
        }

        return SongViewModel::fromEntity($song);
    }
}
