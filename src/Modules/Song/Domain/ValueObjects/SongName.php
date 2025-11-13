<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\ValueObjects;

use App\Modules\Song\Domain\Exceptions\InvalidSongNameException;
use Webmozart\Assert\Assert;

final readonly class SongName
{
    /**
     * @throws InvalidSongNameException
     */
    public function __construct(
        private string $value
    )
    {
        try {
            Assert::notEmpty($value, 'Song name cannot be empty');
            Assert::maxLength($value, 255, 'Song name cannot exceed 255 characters');
        } catch (\InvalidArgumentException $e) {
            throw InvalidSongNameException::withReason($e->getMessage());
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
