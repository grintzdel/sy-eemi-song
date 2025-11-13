<?php

declare(strict_types=1);

namespace App\Modules\Album\Domain\Repositories;

use App\Modules\Album\Domain\Entities\Album;
use App\Modules\Shared\Domain\ValueObjects\AlbumId;
use App\Modules\Shared\Domain\ValueObjects\SongId;
use App\Modules\Shared\Domain\ValueObjects\UserId;

interface IAlbumRepository
{
    /*
     * Queries
     */
    public function findById(AlbumId $id): ?Album;

    public function findByArtistId(UserId $artistId): array;

    public function findAll(): array;

    /*
     * Commands
     */
    public function save(Album $album): void;

    public function delete(AlbumId $id): void;

    public function addSongToAlbum(AlbumId $albumId, SongId $songId): void;

    public function removeSongFromAlbum(AlbumId $albumId, SongId $songId): void;
}
