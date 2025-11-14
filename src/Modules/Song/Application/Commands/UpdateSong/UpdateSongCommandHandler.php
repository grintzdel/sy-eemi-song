<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Commands\UpdateSong;

use App\Modules\Shared\Application\Services\IUserProvider;
use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use App\Modules\Shared\Domain\ValueObjects\CoverImage;
use App\Modules\Shared\Domain\ValueObjects\SongId;
use App\Modules\Shared\Domain\ValueObjects\TagId;
use App\Modules\Shared\Domain\ValueObjects\UserId;
use App\Modules\Song\Application\ViewModels\SongViewModel;
use App\Modules\Song\Domain\Exceptions\InvalidDurationException;
use App\Modules\Song\Domain\Exceptions\InvalidSongNameException;
use App\Modules\Song\Domain\Exceptions\SongNotFoundException;
use App\Modules\Song\Domain\Exceptions\UnauthorizedSongAccessException;
use App\Modules\Song\Domain\Repositories\ISongRepository;
use App\Modules\Song\Domain\ValueObjects\SongDuration;
use App\Modules\Song\Domain\ValueObjects\SongName;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UpdateSongCommandHandler
{
    public function __construct(
        private ISongRepository $songRepository,
        private IUserProvider $userProvider,
    ) {
    }

    /**
     * @throws InvalidSongNameException
     * @throws UnauthorizedSongAccessException
     * @throws InvalidDurationException
     * @throws SongNotFoundException
     */
    public function __invoke(UpdateSongCommand $command): SongViewModel
    {
        $songId = new SongId($command->getId());
        $song = $this->songRepository->findById($songId);

        if (null === $song) {
            throw SongNotFoundException::withId($command->getId());
        }

        $currentUserId = new UserId($this->userProvider->getUserId());
        if (!$song->isOwnedBy($currentUserId)) {
            throw UnauthorizedSongAccessException::forUser($this->userProvider->getUserId(), $command->getId());
        }

        $tagId = null !== $command->getTagId()
            ? new TagId($command->getTagId())
            : null;

        $coverImage = null !== $command->getCoverImage()
            ? new CoverImage($command->getCoverImage())
            : null;

        $song->update(
            name: new SongName($command->getName()),
            categoryId: new CategoryId($command->getCategoryId()),
            tagId: $tagId,
            duration: new SongDuration($command->getDuration()),
            coverImage: $coverImage
        );

        $this->songRepository->save($song);

        return SongViewModel::fromEntity($song);
    }
}
