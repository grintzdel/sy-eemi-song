<?php

declare(strict_types=1);

namespace App\Modules\Shared\Domain\ValueObjects;

use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

final readonly class TagId
{
    public function __construct(
        private string $value
    )
    {
        Assert::notEmpty($this->value, 'Tag ID cannot be empty');
        Assert::uuid($this->value, 'Tag ID must be a valid UUID');
    }

    public static function generate(): self
    {
        return new self(Uuid::v4()->toRfc4122());
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(TagId $other): bool
    {
        return $this->value === $other->value;
    }
}
