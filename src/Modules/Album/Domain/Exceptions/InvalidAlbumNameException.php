<?php

declare(strict_types=1);

namespace App\Modules\Album\Domain\Exceptions;

final class InvalidAlbumNameException extends AlbumException
{
    public static function fromMessage(string $message): self
    {
        return new self(sprintf('Invalid album name: %s', $message));
    }
}
