<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Queries\GetSongsByCategory;

use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use App\Modules\Song\Application\ViewModels\SongViewModel;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetSongsByCategoryQueryHandler
{
    public function __construct(
        private ISongRepository $songRepository
    ) {}

    public function __invoke(GetSongsByCategoryQuery $query): array
    {
        $songs = $this->songRepository->findByCategoryId(new CategoryId($query->getCategoryId()));

        return array_map(
            fn($song) => SongViewModel::fromEntity($song),
            $songs
        );
    }
}
