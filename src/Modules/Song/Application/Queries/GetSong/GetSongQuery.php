<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Queries\GetSong;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class GetSongQuery
{
    #[Assert\NotBlank(message: 'Song ID is required')]
    #[Assert\Uuid(message: 'Song ID must be a valid UUID')]
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
