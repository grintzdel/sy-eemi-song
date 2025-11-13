<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Commands\DeleteSong;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class DeleteSongCommand
{
    #[Assert\NotBlank(message: 'Song ID is required')]
    #[Assert\Uuid(message: 'Song ID must be a valid UUID')]
    private string $id;

    #[Assert\NotBlank(message: 'Artist ID is required')]
    #[Assert\Uuid(message: 'Artist ID must be a valid UUID')]
    private string $artistId;

    public function __construct(
        string $id,
        string $artistId
    )
    {
        $this->id = $id;
        $this->artistId = $artistId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getArtistId(): string
    {
        return $this->artistId;
    }
}
