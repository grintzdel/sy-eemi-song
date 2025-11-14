<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Commands\DeleteSong;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class DeleteSongCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'Song ID is required')]
        #[Assert\Uuid(message: 'Song ID must be a valid UUID')]
        private string $id,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
