<?php

declare(strict_types=1);

namespace App\Modules\Album\Domain\Exceptions;

final class AlbumNotFoundException extends AlbumException
{
    public static function withId(string $id): self
    {
        return new self(sprintf('Album with id "%s" not found', $id));
    }
}
