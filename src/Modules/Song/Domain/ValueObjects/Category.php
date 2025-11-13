<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\ValueObjects;

use App\Modules\Song\Domain\Exceptions\InvalidCategoryException;
use Webmozart\Assert\Assert;

final readonly class Category
{
    /**
     * @throws InvalidCategoryException
     */
    public function __construct(
        private string $value
    )
    {
        try {
            Assert::notEmpty($value, 'Category cannot be empty');
            Assert::maxLength($value, 100, 'Category cannot exceed 100 characters');
        } catch (\InvalidArgumentException $e) {
            throw InvalidCategoryException::withReason($e->getMessage());
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
