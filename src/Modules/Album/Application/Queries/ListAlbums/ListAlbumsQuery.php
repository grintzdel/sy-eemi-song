<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Queries\ListAlbums;

final readonly class ListAlbumsQuery
{
    public function __construct(
        private ?string $artistId = null
    ) {}

    public function getArtistId(): ?string
    {
        return $this->artistId;
    }
}
