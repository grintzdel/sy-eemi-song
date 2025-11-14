<?php

declare(strict_types=1);

namespace App\Modules\Album\Presentation\Controllers;

use App\Modules\Album\Application\Commands\AddSongToAlbum\AddSongToAlbumCommand;
use App\Modules\Album\Application\Commands\CreateAlbum\CreateAlbumCommand;
use App\Modules\Album\Application\Commands\DeleteAlbum\DeleteAlbumCommand;
use App\Modules\Album\Application\Commands\RemoveSongFromAlbum\RemoveSongFromAlbumCommand;
use App\Modules\Album\Application\Commands\UpdateAlbum\UpdateAlbumCommand;
use App\Modules\Album\Application\Queries\GetAlbum\GetAlbumQuery;
use App\Modules\Album\Application\Queries\ListAlbums\ListAlbumsQuery;
use App\Modules\Shared\Presentation\Controllers\AppController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/albums', format: 'json')]
class AlbumController extends AppController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('', methods: ['GET'])]
    public function listAlbums(): JsonResponse
    {
        return $this->dispatchQuery(new ListAlbumsQuery());
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{id}', methods: ['GET'])]
    public function getAlbum(string $id): JsonResponse
    {
        return $this->dispatchQuery(new GetAlbumQuery($id));
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('', methods: ['POST'])]
    #[IsGranted('ROLE_ARTIST', message: 'Only artists can create albums')]
    public function createAlbum(#[MapRequestPayload] CreateAlbumCommand $command): JsonResponse
    {
        return $this->dispatch($command);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{id}', methods: ['PUT'])]
    #[IsGranted('ROLE_ARTIST', message: 'Only artists can update albums')]
    public function updateAlbum(string $id, #[MapRequestPayload] UpdateAlbumCommand $command): JsonResponse
    {
        return $this->dispatch($command);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{id}', methods: ['DELETE'])]
    #[IsGranted('ROLE_ARTIST', message: 'Only artists can delete albums')]
    public function deleteAlbum(string $id): JsonResponse
    {
        return $this->dispatch(new DeleteAlbumCommand($id));
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{albumId}/songs/{songId}', methods: ['POST'])]
    #[IsGranted('ROLE_ARTIST', message: 'Only artists can add songs to albums')]
    public function addSongToAlbum(string $albumId, string $songId): JsonResponse
    {
        return $this->dispatch(new AddSongToAlbumCommand($albumId, $songId));
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/{albumId}/songs/{songId}', methods: ['DELETE'])]
    #[IsGranted('ROLE_ARTIST', message: 'Only artists can remove songs from albums')]
    public function removeSongFromAlbum(string $albumId, string $songId): JsonResponse
    {
        return $this->dispatch(new RemoveSongFromAlbumCommand($albumId, $songId));
    }
}
