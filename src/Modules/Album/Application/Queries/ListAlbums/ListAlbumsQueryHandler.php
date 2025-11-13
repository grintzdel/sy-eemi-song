<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Queries\ListAlbums;

use App\Modules\Album\Application\ViewModels\AlbumViewModel;
use App\Modules\Album\Domain\Repositories\IAlbumRepository;
use App\Modules\Shared\Domain\ValueObjects\UserId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ListAlbumsQueryHandler
{
    public function __construct(
        private IAlbumRepository $albumRepository
    ) {}

    public function __invoke(ListAlbumsQuery $query): array
    {
        if ($query->getAuthorId() !== null) {
            $albums = $this->albumRepository->findByAuthorId(
                new UserId($query->getAuthorId())
            );
        } else {
            $albums = $this->albumRepository->findAll();
        }

        return array_map(
            fn($album) => new AlbumViewModel(
                id: $album->getId()->getValue(),
                authorId: $album->getAuthorId()->getValue(),
                name: $album->getName()->getValue(),
                createdAt: $album->getCreatedAt(),
                updatedAt: $album->getUpdatedAt(),
                deletedAt: $album->getDeletedAt()
            ),
            $albums
        );
    }
}
