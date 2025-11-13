<?php

declare(strict_types=1);

namespace App\Modules\Category\Domain\Exceptions;

final class CategoryNotFoundException extends CategoryException
{
    public static function withId(string $id): self
    {
        return new self(sprintf('Category with id "%s" not found', $id));
    }
}
