<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Queries\ListSongs;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class ListSongsQuery
{
    #[Assert\Uuid(message: 'Artist ID must be a valid UUID')]
    private ?string $artistId;

    #[Assert\Length(max: 100, maxMessage: 'Category cannot exceed 100 characters')]
    private ?string $category;

    public function __construct(?string $artistId = null, ?string $category = null)
    {
        $this->artistId = $artistId;
        $this->category = $category;
    }

    public function getArtistId(): ?string
    {
        return $this->artistId;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }
}
