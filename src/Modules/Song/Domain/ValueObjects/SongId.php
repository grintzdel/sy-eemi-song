<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\ValueObjects;

use Webmozart\Assert\Assert;

final readonly class SongId
{
    public function __construct(
        private string $value
    )
    {
        Assert::uuid($value, 'Song ID must be a valid UUID');
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(SongId $other): bool
    {
        return $this->value === $other->value;
    }
}
