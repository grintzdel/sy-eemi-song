<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Queries\GetSongsByAlbum;

use App\Modules\Shared\Domain\ValueObjects\AlbumId;
use App\Modules\Song\Application\ViewModels\SongViewModel;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetSongsByAlbumQueryHandler
{
    public function __construct(
        private ISongRepository $songRepository
    ) {}

    public function __invoke(GetSongsByAlbumQuery $query): array
    {
        $songs = $this->songRepository->findByAlbumId(new AlbumId($query->getAlbumId()));

        return array_map(
            fn($song) => SongViewModel::fromEntity($song),
            $songs
        );
    }
}
