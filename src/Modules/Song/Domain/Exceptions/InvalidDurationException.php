<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\Exceptions;

final class InvalidDurationException extends SongException
{
    public static function withReason(string $reason): self
    {
        return new self(sprintf('Invalid duration: %s', $reason));
    }
}
