<?php

declare(strict_types=1);

namespace App\Modules\Album\Application\Queries\GetAlbum;

final readonly class GetAlbumQuery
{
    public function __construct(
        private string $id
    ) {}

    public function getId(): string
    {
        return $this->id;
    }
}
