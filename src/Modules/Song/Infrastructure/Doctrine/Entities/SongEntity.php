<?php

declare(strict_types=1);

namespace App\Modules\Song\Infrastructure\Doctrine\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'songs')]
class SongEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36)]
    private string $id;

    #[ORM\Column(name: 'artist_id', type: 'string', length: 36)]
    private string $artistId;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(name: 'category_id', type: 'string', length: 36)]
    private string $categoryId;

    #[ORM\ManyToMany(targetEntity: 'App\Modules\Album\Infrastructure\Doctrine\Entities\AlbumEntity', inversedBy: 'songs')]
    #[ORM\JoinTable(name: 'song_albums')]
    #[ORM\JoinColumn(name: 'song_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'album_id', referencedColumnName: 'id')]
    private Collection $albums;

    #[ORM\Column(name: 'tag_id', type: 'string', length: 36, nullable: true)]
    private ?string $tagId;

    #[ORM\Column(type: 'integer')]
    private int $duration;

    #[ORM\Column(name: 'cover_image', type: 'string', length: 500, nullable: true)]
    private ?string $coverImage;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(name: 'deleted_at', type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $deletedAt;

    public function __construct(
        string $id,
        string $artistId,
        string $name,
        string $categoryId,
        ?string $tagId,
        int $duration,
        ?string $coverImage,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
        ?\DateTimeImmutable $deletedAt = null
    )
    {
        $this->id = $id;
        $this->artistId = $artistId;
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->tagId = $tagId;
        $this->duration = $duration;
        $this->coverImage = $coverImage;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
        $this->albums = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getArtistId(): string
    {
        return $this->artistId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function setCategoryId(string $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum($album): void
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
        }
    }

    public function removeAlbum($album): void
    {
        $this->albums->removeElement($album);
    }

    public function getTagId(): ?string
    {
        return $this->tagId;
    }

    public function setTagId(?string $tagId): void
    {
        $this->tagId = $tagId;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): void
    {
        $this->coverImage = $coverImage;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}
