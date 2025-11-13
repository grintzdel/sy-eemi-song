<?php

declare(strict_types=1);

namespace App\Modules\Song\Application\Commands\CreateSong;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateSongCommand
{
    #[Assert\NotBlank(message: 'Artist ID is required')]
    #[Assert\Uuid(message: 'Artist ID must be a valid UUID')]
    private string $artistId;

    #[Assert\NotBlank(message: 'Song name is required')]
    #[Assert\Length(max: 255, maxMessage: 'Song name cannot exceed 255 characters')]
    private string $name;

    #[Assert\NotBlank(message: 'Category is required')]
    #[Assert\Length(max: 100, maxMessage: 'Category cannot exceed 100 characters')]
    private string $category;

    #[Assert\Length(max: 255, maxMessage: 'Album name cannot exceed 255 characters')]
    private ?string $album;

    #[Assert\Length(max: 100, maxMessage: 'Tag cannot exceed 100 characters')]
    private ?string $tag;

    #[Assert\NotBlank(message: 'Duration is required')]
    #[Assert\Positive(message: 'Duration must be greater than 0')]
    #[Assert\LessThan(value: 86400, message: 'Duration cannot exceed 24 hours')]
    private int $duration;

    public function __construct(
        string $artistId,
        string $name,
        string $category,
        ?string $album,
        ?string $tag,
        int $duration
    )
    {
        $this->artistId = $artistId;
        $this->name = $name;
        $this->category = $category;
        $this->album = $album;
        $this->tag = $tag;
        $this->duration = $duration;
    }

    public function getArtistId(): string
    {
        return $this->artistId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getAlbum(): ?string
    {
        return $this->album;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }
}
