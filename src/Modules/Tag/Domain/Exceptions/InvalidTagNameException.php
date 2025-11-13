<?php

declare(strict_types=1);

namespace App\Modules\Tag\Domain\Exceptions;

use DomainException;

final class InvalidTagNameException extends DomainException
{
    public static function fromInvalidFormat(string $message): self
    {
        return new self($message);
    }
}
