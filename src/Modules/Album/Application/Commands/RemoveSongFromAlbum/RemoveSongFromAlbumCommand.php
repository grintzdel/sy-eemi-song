<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Commands\RemoveSongFromAlbum;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class RemoveSongFromAlbumCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'Album ID is required')]
        #[Assert\Uuid(message: 'Album ID must be a valid UUID')]
        private string $albumId,

        #[Assert\NotBlank(message: 'Song ID is required')]
        #[Assert\Uuid(message: 'Song ID must be a valid UUID')]
        private string $songId,
    ) {
    }

    public function getAlbumId(): string
    {
        return $this->albumId;
    }

    public function getSongId(): string
    {
        return $this->songId;
    }
}
