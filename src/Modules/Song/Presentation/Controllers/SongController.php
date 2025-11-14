<?php

declare(strict_types=1);

namespace App\Modules\Song\Presentation\Controllers;

use App\Modules\Shared\Presentation\Controllers\AppController;
use App\Modules\Song\Application\Commands\CreateSong\CreateSongCommand;
use App\Modules\Song\Application\Commands\DeleteSong\DeleteSongCommand;
use App\Modules\Song\Application\Commands\UpdateSong\UpdateSongCommand;
use App\Modules\Song\Application\Queries\GetSong\GetSongQuery;
use App\Modules\Song\Application\Queries\GetSongsByAlbum\GetSongsByAlbumQuery;
use App\Modules\Song\Application\Queries\GetSongsByCategory\GetSongsByCategoryQuery;
use App\Modules\Song\Application\Queries\GetSongsByTag\GetSongsByTagQuery;
use App\Modules\Song\Application\Queries\ListSongs\ListSongsQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/songs', format: 'json')]
class SongController extends AppController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('', methods: ['GET'])]
    public function listSongs(): JsonResponse
    {
        return $this->dispatchQuery(new ListSongsQuery());
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{id}', methods: ['GET'])]
    public function getSong(string $id): JsonResponse
    {
        return $this->dispatchQuery(new GetSongQuery($id));
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/tag/{tagId}', methods: ['GET'])]
    public function getSongsByTag(string $tagId): JsonResponse
    {
        return $this->dispatchQuery(new GetSongsByTagQuery($tagId));
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/category/{categoryId}', methods: ['GET'])]
    public function getSongsByCategory(string $categoryId): JsonResponse
    {
        return $this->dispatchQuery(new GetSongsByCategoryQuery($categoryId));
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/album/{albumId}', methods: ['GET'])]
    public function getSongsByAlbum(string $albumId): JsonResponse
    {
        return $this->dispatchQuery(new GetSongsByAlbumQuery($albumId));
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('', methods: ['POST'])]
    #[IsGranted('ROLE_ARTIST', message: 'Only artists can create songs')]
    public function createSong(#[MapRequestPayload] CreateSongCommand $command): JsonResponse
    {
        return $this->dispatch($command);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{id}', methods: ['PUT'])]
    #[IsGranted('ROLE_ARTIST', message: 'Only artists can update songs')]
    public function updateSong(string $id, #[MapRequestPayload] UpdateSongCommand $command): JsonResponse
    {
        return $this->dispatch($command);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{id}', methods: ['DELETE'])]
    #[IsGranted('ROLE_ARTIST', message: 'Only artists can delete songs')]
    public function deleteSong(string $id): JsonResponse
    {
        return $this->dispatch(new DeleteSongCommand($id));
    }
}
