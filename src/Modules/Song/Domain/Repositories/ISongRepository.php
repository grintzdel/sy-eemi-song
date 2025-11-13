<?php

declare(strict_types=1);

namespace App\Modules\Song\Domain\Repositories;

use App\Modules\Song\Domain\Entities\Song;
use App\Modules\Song\Domain\ValueObjects\SongId;
use App\Modules\Song\Domain\ValueObjects\UserId;

interface ISongRepository
{
    public function findById(SongId $id): ?Song;

    /**
     * @return Song[]
     */
    public function findByArtistId(UserId $artistId): array;

    /**
     * @return Song[]
     */
    public function findAll(): array;

    public function save(Song $song): void;

    public function delete(SongId $id): void;
}