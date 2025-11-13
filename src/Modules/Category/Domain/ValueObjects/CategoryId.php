<?php

declare(strict_types=1);

namespace App\Modules\Category\Domain\ValueObjects;

use Webmozart\Assert\Assert;

final readonly class CategoryId
{
    public function __construct(
        private string $value
    )
    {
        Assert::uuid($value, 'Category ID must be a valid UUID');
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
