<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\ValueObjects;

use Webmozart\Assert\Assert;

final readonly class SongTag
{
    private ?string $value;

    public function __construct(?string $value)
    {
        if ($value !== null) {
            Assert::maxLength($value, 100, 'Tag cannot exceed 100 characters');
        }

        $this->value = $value;
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
