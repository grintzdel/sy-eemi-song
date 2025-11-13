<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Queries\ListSongs;

use App\Modules\Shared\Domain\ValueObjects\UserId;
use App\Modules\Song\Application\ViewModels\SongViewModel;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ListSongsQueryHandler
{
    public function __construct(
        private ISongRepository $songRepository
    ) {}

    /**
     * @return SongViewModel[]
     */
    public function __invoke(ListSongsQuery $query): array
    {
        if ($query->getArtistId() !== null) {
            $songs = $this->songRepository->findByArtistId(new UserId($query->getArtistId()));
        } else {
            $songs = $this->songRepository->findAll();
        }

        if ($query->getCategory() !== null) {
            $songs = array_filter(
                $songs,
                fn($song) => $song->getCategory()->getValue() === $query->getCategory()
            );
        }

        return array_map(
            fn($song) => SongViewModel::fromEntity($song),
            $songs
        );
    }
}
