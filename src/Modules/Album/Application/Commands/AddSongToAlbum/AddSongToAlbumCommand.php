<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Commands\AddSongToAlbum;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class AddSongToAlbumCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'Album ID is required')]
        #[Assert\Uuid(message: 'Album ID must be a valid UUID')]
        private string $albumId,

        #[Assert\NotBlank(message: 'Song ID is required')]
        #[Assert\Uuid(message: 'Song ID must be a valid UUID')]
        private string $songId,

        #[Assert\NotBlank(message: 'Artist ID is required')]
        #[Assert\Uuid(message: 'Artist ID must be a valid UUID')]
        private string $artistId
    ) {}

    public function getAlbumId(): string
    {
        return $this->albumId;
    }

    public function getSongId(): string
    {
        return $this->songId;
    }

    public function getArtistId(): string
    {
        return $this->artistId;
    }
}
