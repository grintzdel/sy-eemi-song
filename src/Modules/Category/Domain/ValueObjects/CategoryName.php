<?php

declare(strict_types=1);

namespace App\Modules\Category\Domain\ValueObjects;

use App\Modules\Category\Domain\Exceptions\InvalidCategoryNameException;
use Webmozart\Assert\Assert;

final readonly class CategoryName
{
    /**
     * @throws InvalidCategoryNameException
     */
    public function __construct(
        private string $value
    )
    {
        try {
            Assert::notEmpty($value, 'Category name cannot be empty');
            Assert::maxLength($value, 100, 'Category name cannot exceed 100 characters');
        } catch (\InvalidArgumentException $e) {
            throw InvalidCategoryNameException::fromMessage($e->getMessage());
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
