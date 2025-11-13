<?php

declare(strict_types=1);

namespace App\Modules\Song\Presentation\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Modules\Song\Presentation\State\Processor\CreateSongProcessor;
use App\Modules\Song\Presentation\State\Processor\DeleteSongProcessor;
use App\Modules\Song\Presentation\State\Processor\UpdateSongProcessor;
use App\Modules\Song\Presentation\State\Provider\GetSongProvider;
use App\Modules\Song\Presentation\State\Provider\ListSongsProvider;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Song',
    operations: [
        new GetCollection(
            security: 'is_granted("PUBLIC_ACCESS")',
            provider: ListSongsProvider::class
        ),
        new Get(
            security: 'is_granted("PUBLIC_ACCESS")',
            provider: GetSongProvider::class
        ),
        new Post(
            security: 'is_granted("ROLE_ARTIST")',
            securityMessage: 'Only artists can create songs',
            processor: CreateSongProcessor::class
        ),
        new Put(
            security: 'is_granted("ROLE_ARTIST")',
            securityMessage: 'Only artists can update songs',
            processor: UpdateSongProcessor::class
        ),
        new Delete(
            security: 'is_granted("ROLE_ARTIST")',
            securityMessage: 'Only artists can delete songs',
            processor: DeleteSongProcessor::class
        ),
    ],
    routePrefix: '/songs'
)]
class SongResource
{
    #[ApiProperty(identifier: true)]
    public ?string $id = null;

    #[Assert\NotBlank(message: 'Artist ID is required')]
    #[Assert\Uuid(message: 'Artist ID must be a valid UUID')]
    public string $artistId;

    #[Assert\NotBlank(message: 'Song name is required')]
    #[Assert\Length(max: 255, maxMessage: 'Song name cannot exceed 255 characters')]
    public string $name;

    #[Assert\NotBlank(message: 'Category is required')]
    #[Assert\Length(max: 100, maxMessage: 'Category cannot exceed 100 characters')]
    public string $category;

    #[Assert\Length(max: 255, maxMessage: 'Album name cannot exceed 255 characters')]
    public ?string $album = null;

    #[Assert\Length(max: 100, maxMessage: 'Tag cannot exceed 100 characters')]
    public ?string $tag = null;

    #[Assert\NotBlank(message: 'Duration is required')]
    #[Assert\Positive(message: 'Duration must be greater than 0')]
    #[Assert\LessThan(value: 86400, message: 'Duration cannot exceed 24 hours')]
    public int $duration;

    public ?string $durationFormatted = null;

    public ?string $createdAt = null;

    public ?string $updatedAt = null;

    public ?string $deletedAt = null;
}
