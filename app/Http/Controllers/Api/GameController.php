<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RawgService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct(
        protected RawgService $rawg,
    ) {}

    public function safe(Request $request): JsonResponse
    {
        $search = $request->string('search');
        $page = $request->integer('page', 1);
        $genre = $request->string('genre');
        $sortBy = $request->string('sort', '-rating');

        $params = [
            'page' => $page,
            'ordering' => $sortBy,
        ];

        if ($search->isNotEmpty()) {
            $params['search'] = $search->value();
        }

        if ($genre->isNotEmpty()) {
            $params['genres'] = $genre->value();
        }

        $data = $this->rawg->getSafeGames($params);

        return response()->json([
            'data' => $data['results'] ?? [],
            'total' => $data['count'] ?? 0,
            'current_page' => $page,
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $game = $this->rawg->getGame($id);

        if ($game === null) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        $screenshots = $this->rawg->getScreenshots($id);

        return response()->json([
            'data' => $game,
            'screenshots' => $screenshots,
        ]);
    }
}
