<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\ValueObjects;

use App\Modules\Song\Domain\Exceptions\InvalidDurationException;
use Webmozart\Assert\Assert;

final readonly class SongDuration
{
    /**
     * @throws InvalidDurationException
     */
    public function __construct(
        private int $seconds
    )
    {
        try {
            Assert::greaterThan($seconds, 0, 'Duration must be greater than 0 seconds');
            Assert::lessThan($seconds, 86400, 'Duration cannot exceed 24 hours (86400 seconds)');
        } catch (\InvalidArgumentException $e) {
            throw InvalidDurationException::withReason($e->getMessage());
        }
    }

    public function getSeconds(): int
    {
        return $this->seconds;
    }

    public function getMinutes(): float
    {
        return round($this->seconds / 60, 2);
    }

    public function getFormatted(): string
    {
        $minutes = floor($this->seconds / 60);
        $seconds = $this->seconds % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    public function __toString(): string
    {
        return (string) $this->seconds;
    }
}
