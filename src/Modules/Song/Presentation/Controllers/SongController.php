<?php

declare(strict_types=1);

namespace App\Modules\Song\Presentation\Controllers;

use App\Modules\Shared\Presentation\Controllers\AppController;
use App\Modules\Song\Application\Commands\CreateSong\CreateSongCommand;
use App\Modules\Song\Application\Commands\DeleteSong\DeleteSongCommand;
use App\Modules\Song\Application\Commands\UpdateSong\UpdateSongCommand;
use App\Modules\Song\Application\Queries\GetSong\GetSongQuery;
use App\Modules\Song\Application\Queries\ListSongs\ListSongsQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SongController extends AppController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/songs', methods: ['POST'], format: 'json')]
    #[IsGranted('ROLE_ARTIST')]
    public function createSong(#[MapRequestPayload] CreateSongCommand $command): JsonResponse
    {
        return $this->dispatch($command);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/songs/{id}', methods: ['PUT'], format: 'json')]
    #[IsGranted('ROLE_ARTIST')]
    public function updateSong(string $id, #[MapRequestPayload] UpdateSongCommand $command): JsonResponse
    {
        return $this->dispatch($command);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/songs/{id}', methods: ['DELETE'], format: 'json')]
    #[IsGranted('ROLE_ARTIST')]
    public function deleteSong(string $id, Request $request): JsonResponse
    {
        $artistId = $request->request->get('artistId');
        $command = new DeleteSongCommand($id, $artistId);

        return $this->dispatch($command);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/songs/{id}', methods: ['GET'], format: 'json')]
    public function getSong(string $id): JsonResponse
    {
        $query = new GetSongQuery($id);

        return $this->dispatchQuery($query);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/songs', methods: ['GET'], format: 'json')]
    public function listSongs(Request $request): JsonResponse
    {
        $artistId = $request->query->get('artistId');
        $category = $request->query->get('category');

        $query = new ListSongsQuery($artistId, $category);

        return $this->dispatchQuery($query);
    }
}
