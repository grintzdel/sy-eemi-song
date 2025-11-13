<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Commands\CreateSong;

use App\Modules\Shared\Application\Ports\Services\IIdProvider;
use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use App\Modules\Shared\Domain\ValueObjects\CoverImage;
use App\Modules\Shared\Domain\ValueObjects\SongId;
use App\Modules\Shared\Domain\ValueObjects\TagId;
use App\Modules\Shared\Domain\ValueObjects\UserId;
use App\Modules\Song\Application\ViewModels\IdViewModel;
use App\Modules\Song\Domain\Entities\Song;
use App\Modules\Song\Domain\Exceptions\InvalidDurationException;
use App\Modules\Song\Domain\Exceptions\InvalidSongNameException;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use App\Modules\Song\Domain\ValueObjects\SongDuration;
use App\Modules\Song\Domain\ValueObjects\SongName;
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
     * @throws InvalidDurationException
     */
    public function __invoke(CreateSongCommand $command): IdViewModel
    {
        $tagId = $command->getTagId() !== null
            ? new TagId($command->getTagId())
            : null;

        $coverImage = $command->getCoverImage() !== null
            ? new CoverImage($command->getCoverImage())
            : null;

        $song = Song::create(
            id: new SongId($this->idProvider->generateId()),
            artistId: new UserId($command->getArtistId()),
            name: new SongName($command->getName()),
            categoryId: new CategoryId($command->getCategoryId()),
            tagId: $tagId,
            duration: new SongDuration($command->getDuration()),
            coverImage: $coverImage
        );

        $this->songRepository->save($song);

        return new IdViewModel($song->getId()->getValue());
    }
}
