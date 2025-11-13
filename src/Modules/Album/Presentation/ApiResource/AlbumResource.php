<?php

declare(strict_types=1);

namespace App\Modules\Album\Presentation\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Modules\Album\Presentation\State\Processor\CreateAlbumProcessor;
use App\Modules\Album\Presentation\State\Processor\DeleteAlbumProcessor;
use App\Modules\Album\Presentation\State\Processor\UpdateAlbumProcessor;
use App\Modules\Album\Presentation\State\Provider\GetAlbumProvider;
use App\Modules\Album\Presentation\State\Provider\ListAlbumsProvider;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Album',
    operations: [
        new GetCollection(
            security: 'is_granted("PUBLIC_ACCESS")',
            provider: ListAlbumsProvider::class
        ),
        new Get(
            security: 'is_granted("PUBLIC_ACCESS")',
            provider: GetAlbumProvider::class
        ),
        new Post(
            security: 'is_granted("ROLE_ARTIST")',
            processor: CreateAlbumProcessor::class
        ),
        new Put(
            security: 'is_granted("ROLE_ARTIST")',
            processor: UpdateAlbumProcessor::class
        ),
        new Delete(
            security: 'is_granted("ROLE_ARTIST")',
            processor: DeleteAlbumProcessor::class
        )
    ],
    routePrefix: '/albums'
)]
class AlbumResource
{
    public ?string $id = null;

    #[Assert\NotBlank(message: 'Artist ID is required')]
    #[Assert\Uuid(message: 'Artist ID must be a valid UUID')]
    public ?string $artistId = null;

    #[Assert\NotBlank(message: 'Album name is required')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Album name cannot exceed {{ limit }} characters'
    )]
    public ?string $name = null;

    #[Assert\Uuid(message: 'Category ID must be a valid UUID')]
    public ?string $categoryId = null;

    #[Assert\Length(
        max: 500,
        maxMessage: 'Cover image URL cannot exceed {{ limit }} characters'
    )]
    public ?string $coverImage = null;

    public ?\DateTimeImmutable $createdAt = null;

    public ?\DateTimeImmutable $updatedAt = null;

    public ?\DateTimeImmutable $deletedAt = null;
}
