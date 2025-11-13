<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\Exceptions;

final class UnauthorizedSongAccessException extends SongException
{
    public static function forUser(string $userId, string $songId): self
    {
        return new self(
            sprintf('User "%s" is not authorized to access song "%s"', $userId, $songId)
        );
    }
}
