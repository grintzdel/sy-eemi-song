<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Queries\GetSongsByTag;

use App\Modules\Shared\Domain\ValueObjects\TagId;
use App\Modules\Song\Application\ViewModels\SongViewModel;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetSongsByTagQueryHandler
{
    public function __construct(
        private ISongRepository $songRepository
    ) {}

    public function __invoke(GetSongsByTagQuery $query): array
    {
        $songs = $this->songRepository->findByTagId(new TagId($query->getTagId()));

        return array_map(
            fn($song) => SongViewModel::fromEntity($song),
            $songs
        );
    }
}
