<?php

declare(strict_types=1);

namespace App\Modules\Tag\Presentation\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Modules\Tag\Presentation\State\Processor\CreateTagProcessor;
use App\Modules\Tag\Presentation\State\Processor\DeleteTagProcessor;
use App\Modules\Tag\Presentation\State\Processor\UpdateTagProcessor;
use App\Modules\Tag\Presentation\State\Provider\GetTagProvider;
use App\Modules\Tag\Presentation\State\Provider\ListTagsProvider;

#[ApiResource(
    shortName: 'Tag',
    operations: [
        new GetCollection(
            security: 'is_granted("PUBLIC_ACCESS")',
            provider: ListTagsProvider::class
        ),
        new Get(
            security: 'is_granted("PUBLIC_ACCESS")',
            provider: GetTagProvider::class
        ),
        new Post(
            security: 'is_granted("ROLE_ADMIN") or is_granted("ROLE_MODERATOR")',
            processor: CreateTagProcessor::class
        ),
        new Put(
            security: 'is_granted("ROLE_ADMIN") or is_granted("ROLE_MODERATOR")',
            processor: UpdateTagProcessor::class
        ),
        new Delete(
            security: 'is_granted("ROLE_ADMIN") or is_granted("ROLE_MODERATOR")',
            processor: DeleteTagProcessor::class
        )
    ],
    routePrefix: '/tags'
)]
class TagResource
{
    public ?string $id = null;
    public ?string $name = null;
    public ?\DateTimeImmutable $createdAt = null;
    public ?\DateTimeImmutable $updatedAt = null;
}
