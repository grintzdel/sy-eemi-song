<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\Repositories;

use App\Modules\Shared\Domain\ValueObjects\AlbumId;
use App\Modules\Shared\Domain\ValueObjects\CategoryId;
use App\Modules\Shared\Domain\ValueObjects\SongId;
use App\Modules\Shared\Domain\ValueObjects\TagId;
use App\Modules\Shared\Domain\ValueObjects\UserId;
use App\Modules\Song\Domain\Entities\Song;

interface ISongRepository
{
    /*
     * Queries
     */
    public function findById(SongId $id): ?Song;

    public function findByArtistId(UserId $artistId): array;

    public function findByTagId(TagId $tagId): array;

    public function findByCategoryId(CategoryId $categoryId): array;

    public function findByAlbumId(AlbumId $albumId): array;

    public function findAll(): array;

    /*
     * Commands
     */
    public function save(Song $song): void;

    public function delete(SongId $id): void;
}
