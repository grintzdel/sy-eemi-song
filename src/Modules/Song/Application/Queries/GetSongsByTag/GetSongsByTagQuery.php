<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Queries\GetSongsByTag;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class GetSongsByTagQuery
{
    #[Assert\NotBlank(message: 'Tag ID is required')]
    #[Assert\Uuid(message: 'Tag ID must be a valid UUID')]
    private string $tagId;

    public function __construct(string $tagId)
    {
        $this->tagId = $tagId;
    }

    public function getTagId(): string
    {
        return $this->tagId;
    }
}
