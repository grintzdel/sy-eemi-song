<?php

declare(strict_types=1);

namespace App\Modules\Album\Domain\ValueObjects;

use Webmozart\Assert\Assert;

final readonly class AlbumId
{
    public function __construct(
        private string $value
    )
    {
        Assert::uuid($value, 'Album ID must be a valid UUID');
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
