<?php

declare(strict_types=1);

namespace App\Modules\Album\Domain\Exceptions;

final class UnauthorizedAlbumAccessException extends AlbumException
{
    public static function forUser(string $userId, string $albumId): self
    {
        return new self(sprintf('User "%s" is not authorized to access album "%s"', $userId, $albumId));
    }
}
