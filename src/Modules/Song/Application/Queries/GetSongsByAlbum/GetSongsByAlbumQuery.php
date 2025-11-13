<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Queries\GetSongsByAlbum;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class GetSongsByAlbumQuery
{
    #[Assert\NotBlank(message: 'Album ID is required')]
    #[Assert\Uuid(message: 'Album ID must be a valid UUID')]
    private string $albumId;

    public function __construct(string $albumId)
    {
        $this->albumId = $albumId;
    }

    public function getAlbumId(): string
    {
        return $this->albumId;
    }
}
