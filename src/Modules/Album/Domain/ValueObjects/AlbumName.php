<?php

declare(strict_types=1);

namespace App\Modules\Album\Domain\ValueObjects;

use Webmozart\Assert\Assert;
use App\Modules\Album\Domain\Exceptions\InvalidAlbumNameException;

final readonly class AlbumName
{
    /**
     * @throws InvalidAlbumNameException
     */
    public function __construct(
        private string $value
    )
    {
        try {
            Assert::notEmpty($value, 'Album name cannot be empty');
            Assert::maxLength($value, 255, 'Album name cannot exceed 255 characters');
        } catch (\InvalidArgumentException $e) {
            throw InvalidAlbumNameException::fromMessage($e->getMessage());
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
