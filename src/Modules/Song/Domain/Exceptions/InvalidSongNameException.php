<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\Exceptions;

final class InvalidSongNameException extends SongException
{
    public static function withReason(string $reason): self
    {
        return new self(sprintf('Invalid song name: %s', $reason));
    }
}
