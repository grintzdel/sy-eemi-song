<?php

declare(strict_types=1);

namespace App\Modules\Tag\Domain\ValueObjects;

use App\Modules\Tag\Domain\Exceptions\InvalidTagNameException;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

final readonly class TagName
{
    public function __construct(
        private string $value
    )
    {
        try {
            Assert::notEmpty($this->value, 'Tag name cannot be empty');
            Assert::maxLength($this->value, 100, 'Tag name cannot exceed 100 characters');
        } catch (InvalidArgumentException $e) {
            throw InvalidTagNameException::fromInvalidFormat($e->getMessage());
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(TagName $other): bool
    {
        return $this->value === $other->value;
    }
}
