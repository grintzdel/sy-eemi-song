<?php

declare(strict_types=1);

namespace App\Modules\Category\Domain\Exceptions;

final class DuplicateCategoryNameException extends CategoryException
{
    public static function withName(string $name): self
    {
        return new self(sprintf('Category with name "%s" already exists', $name));
    }
}
