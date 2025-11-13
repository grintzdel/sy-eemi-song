<?php

declare(strict_types=1);

namespace App\Modules\Tag\Domain\Repositories;

use App\Modules\Shared\Domain\ValueObjects\TagId;
use App\Modules\Tag\Domain\Entities\Tag;

interface ITagRepository
{
    /*
     * Queries
     */
    public function findById(TagId $id): ?Tag;

    public function findAll(): array;

    /*
     * Commands
     */
    public function save(Tag $tag): void;

    public function delete(TagId $id): void;
}
