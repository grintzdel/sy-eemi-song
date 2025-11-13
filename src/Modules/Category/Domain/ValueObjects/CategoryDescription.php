<?php

declare(strict_types=1);

namespace App\Modules\Category\Domain\ValueObjects;

use Webmozart\Assert\Assert;

final readonly class CategoryDescription
{
    public function __construct(
        private ?string $value
    )
    {
        if ($value !== null) {
            Assert::maxLength($value, 500, 'Description cannot exceed 500 characters');
        }
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
