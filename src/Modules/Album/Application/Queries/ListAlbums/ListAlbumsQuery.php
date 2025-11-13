<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Queries\ListAlbums;

final readonly class ListAlbumsQuery
{
    public function __construct(
        private ?string $authorId = null
    ) {}

    public function getAuthorId(): ?string
    {
        return $this->authorId;
    }
}
