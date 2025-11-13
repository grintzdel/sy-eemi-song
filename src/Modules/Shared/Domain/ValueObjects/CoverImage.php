<?php

declare(strict_types=1);

namespace App\Modules\Shared\Domain\ValueObjects;

use Webmozart\Assert\Assert;

final readonly class CoverImage
{
    public function __construct(
        private ?string $value
    )
    {
        if ($this->value !== null) {
            Assert::notEmpty($this->value, 'Cover image URL cannot be empty');
            Assert::maxLength($this->value, 500, 'Cover image URL cannot exceed 500 characters');
        }
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function equals(CoverImage $other): bool
    {
        return $this->value === $other->value;
    }
}
