<?php

declare(strict_types=1);

namespace App\Modules\Category\Presentation\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Modules\Category\Presentation\State\Processor\CreateCategoryProcessor;
use App\Modules\Category\Presentation\State\Processor\DeleteCategoryProcessor;
use App\Modules\Category\Presentation\State\Processor\UpdateCategoryProcessor;
use App\Modules\Category\Presentation\State\Provider\GetCategoryProvider;
use App\Modules\Category\Presentation\State\Provider\ListCategoriesProvider;

#[ApiResource(
    shortName: 'Category',
    operations: [
        new GetCollection(
            security: 'is_granted("PUBLIC_ACCESS")',
            provider: ListCategoriesProvider::class
        ),
        new Get(
            security: 'is_granted("PUBLIC_ACCESS")',
            provider: GetCategoryProvider::class
        ),
        new Post(
            security: 'is_granted("ROLE_ADMIN") or is_granted("ROLE_MODERATOR")',
            processor: CreateCategoryProcessor::class
        ),
        new Put(
            security: 'is_granted("ROLE_ADMIN") or is_granted("ROLE_MODERATOR")',
            processor: UpdateCategoryProcessor::class
        ),
        new Delete(
            security: 'is_granted("ROLE_ADMIN") or is_granted("ROLE_MODERATOR")',
            processor: DeleteCategoryProcessor::class
        )
    ],
    routePrefix: '/categories'
)]
class CategoryResource
{
    public ?string $id = null;
    public ?string $name = null;
    public ?string $description = null;
    public ?\DateTimeImmutable $createdAt = null;
    public ?\DateTimeImmutable $updatedAt = null;
    public ?\DateTimeImmutable $deletedAt = null;
}
