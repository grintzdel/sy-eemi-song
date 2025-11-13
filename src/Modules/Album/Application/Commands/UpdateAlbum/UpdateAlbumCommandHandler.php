<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Commands\UpdateAlbum;

use App\Modules\Album\Application\ViewModels\AlbumViewModel;
use App\Modules\Album\Domain\Exceptions\AlbumNotFoundException;
use App\Modules\Album\Domain\Exceptions\InvalidAlbumNameException;
use App\Modules\Album\Domain\Exceptions\UnauthorizedAlbumAccessException;
use App\Modules\Album\Domain\Repositories\IAlbumRepository;
use App\Modules\Album\Domain\ValueObjects\AlbumId;
use App\Modules\Album\Domain\ValueObjects\AlbumName;
use App\Modules\Song\Domain\ValueObjects\UserId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UpdateAlbumCommandHandler
{
    public function __construct(
        private IAlbumRepository $albumRepository
    ) {}

    /**
     * @throws InvalidAlbumNameException
     * @throws AlbumNotFoundException
     * @throws UnauthorizedAlbumAccessException
     */
    public function __invoke(UpdateAlbumCommand $command): AlbumViewModel
    {
        $albumId = new AlbumId($command->getId());
        $album = $this->albumRepository->findById($albumId);

        if ($album === null) {
            throw AlbumNotFoundException::withId($command->getId());
        }

        $requestingUserId = new UserId($command->getAuthorId());
        if (!$album->isOwnedBy($requestingUserId)) {
            throw UnauthorizedAlbumAccessException::forUser(
                $command->getAuthorId(),
                $command->getId()
            );
        }

        $album->update(new AlbumName($command->getName()));

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
