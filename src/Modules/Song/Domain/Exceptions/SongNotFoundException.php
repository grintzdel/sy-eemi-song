<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\Exceptions;

final class SongNotFoundException extends SongException
{
    public static function withId(string $id): self
    {
        return new self(sprintf('Song with id "%s" not found', $id));
    }
}
