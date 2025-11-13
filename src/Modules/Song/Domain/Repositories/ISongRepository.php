<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\Repositories;

use App\Modules\Shared\Domain\ValueObjects\UserId;
use App\Modules\Song\Domain\Entities\Song;
use App\Modules\Song\Domain\ValueObjects\SongId;

interface ISongRepository
{
    /*
     * Queries
     */
    public function findById(SongId $id): ?Song;

    public function findByArtistId(UserId $artistId): array;

    public function findAll(): array;

    /*
     * Commands
     */
    public function save(Song $song): void;

    public function delete(SongId $id): void;
}
