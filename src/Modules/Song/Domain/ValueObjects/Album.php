<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\ValueObjects;

use Webmozart\Assert\Assert;

final readonly class Album
{
    public function __construct(
        private ?string $value
    )
    {
        if ($value !== null) {
            Assert::maxLength($value, 255, 'Album name cannot exceed 255 characters');
        }
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value ?? '';
    }

    public function isEmpty(): bool
    {
        return $this->value === null || $this->value === '';
    }
}
