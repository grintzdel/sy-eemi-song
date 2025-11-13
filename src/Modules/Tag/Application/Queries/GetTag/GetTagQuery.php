<?php

declare(strict_types=1);

namespace App\Modules\Tag\Application\Queries\GetTag;

final readonly class GetTagQuery
{
    public function __construct(
        private string $id
    ) {}

    public function getId(): string
    {
        return $this->id;
    }
}
