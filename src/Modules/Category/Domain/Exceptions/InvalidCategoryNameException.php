<?php

declare(strict_types=1);

namespace App\Modules\Category\Domain\Exceptions;

final class InvalidCategoryNameException extends CategoryException
{
    public static function fromMessage(string $message): self
    {
        return new self(sprintf('Invalid category name: %s', $message));
    }
}
