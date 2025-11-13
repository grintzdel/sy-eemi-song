<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Commands\CreateAlbum;

use App\Modules\Album\Application\ViewModels\AlbumViewModel;
use App\Modules\Album\Domain\Entities\Album;
use App\Modules\Album\Domain\Exceptions\InvalidAlbumNameException;
use App\Modules\Album\Domain\Repositories\IAlbumRepository;
use App\Modules\Album\Domain\ValueObjects\AlbumId;
use App\Modules\Album\Domain\ValueObjects\AlbumName;
use App\Modules\Shared\Application\Ports\Services\IIdProvider;
use App\Modules\Song\Domain\ValueObjects\UserId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateAlbumCommandHandler
{
    public function __construct(
        private IIdProvider $idProvider,
        private IAlbumRepository $albumRepository
    ) {}

    /**
     * @throws InvalidAlbumNameException
     */
    public function __invoke(CreateAlbumCommand $command): AlbumViewModel
    {
        $album = Album::create(
            id: new AlbumId($this->idProvider->generateId()),
            authorId: new UserId($command->getAuthorId()),
            name: new AlbumName($command->getName())
        );

        $this->albumRepository->save($album);

        return new AlbumViewModel(
            id: $album->getId()->getValue(),
            authorId: $album->getAuthorId()->getValue(),
            name: $album->getName()->getValue(),
            createdAt: $album->getCreatedAt(),
            updatedAt: $album->getUpdatedAt(),
            deletedAt: $album->getDeletedAt()
        );
    }
}
