<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Commands\CreateSong;

use App\Modules\Song\Application\Ports\Services\IIdProvider;
use App\Modules\Song\Application\ViewModels\IdViewModel;
use App\Modules\Song\Domain\Entities\Song;
use App\Modules\Song\Domain\Exceptions\InvalidCategoryException;
use App\Modules\Song\Domain\Exceptions\InvalidDurationException;
use App\Modules\Song\Domain\Exceptions\InvalidSongNameException;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use App\Modules\Song\Domain\ValueObjects\Album;
use App\Modules\Song\Domain\ValueObjects\Category;
use App\Modules\Song\Domain\ValueObjects\Duration;
use App\Modules\Song\Domain\ValueObjects\SongId;
use App\Modules\Song\Domain\ValueObjects\SongName;
use App\Modules\Song\Domain\ValueObjects\Tag;
use App\Modules\Song\Domain\ValueObjects\UserId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateSongCommandHandler
{
    public function __construct(
        private IIdProvider $idProvider,
        private ISongRepository $songRepository
    ) {}

    /**
     * @throws InvalidSongNameException
     * @throws InvalidCategoryException
     * @throws InvalidDurationException
     */
    public function __invoke(CreateSongCommand $command): IdViewModel
    {
        $song = Song::create(
            id: new SongId($this->idProvider->generateId()),
            artistId: new UserId($command->getArtistId()),
            name: new SongName($command->getName()),
            category: new Category($command->getCategory()),
            album: new Album($command->getAlbum()),
            tag: new Tag($command->getTag()),
            duration: new Duration($command->getDuration())
        );

        $this->songRepository->save($song);

        return new IdViewModel($song->getId()->getValue());
    }
}
