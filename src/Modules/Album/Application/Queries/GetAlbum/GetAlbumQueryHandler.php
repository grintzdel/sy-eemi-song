<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Queries\GetAlbum;

use App\Modules\Album\Application\ViewModels\AlbumViewModel;
use App\Modules\Album\Domain\Exceptions\AlbumNotFoundException;
use App\Modules\Album\Domain\Repositories\IAlbumRepository;
use App\Modules\Shared\Domain\ValueObjects\AlbumId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetAlbumQueryHandler
{
    public function __construct(
        private IAlbumRepository $albumRepository
    ) {}

    /**
     * @throws AlbumNotFoundException
     */
    public function __invoke(GetAlbumQuery $query): AlbumViewModel
    {
        $albumId = new AlbumId($query->getId());
        $album = $this->albumRepository->findById($albumId);

        if ($album === null) {
            throw AlbumNotFoundException::withId($query->getId());
        }

        return new AlbumViewModel(
            id: $album->getId()->getValue(),
            artistId: $album->getArtistId()->getValue(),
            name: $album->getName()->getValue(),
            categoryId: $album->getCategoryId()?->getValue(),
            coverImage: $album->getCoverImage()?->getValue(),
            createdAt: $album->getCreatedAt(),
            updatedAt: $album->getUpdatedAt(),
            deletedAt: $album->getDeletedAt()
        );
    }
}
