<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $genre = $request->input('genre');
        $sortBy = $request->input('sort', '-rating');

        $params = [
            'key' => config('services.rawg.key'),
            'page' => $page,
            'page_size' => 20,
            'ordering' => $sortBy,
        ];

        if ($search) {
            $params['search'] = $search;
        }

        if ($genre) {
            $params['genres'] = $genre;
        }

        $response = Http::get(config('services.rawg.base_url').'/games', $params);

        $data = $response->successful() ? $response->json() : ['results' => [], 'count' => 0];

        $genresResponse = Http::get(config('services.rawg.base_url').'/genres', [
            'key' => config('services.rawg.key'),
        ]);

        $genres = $genresResponse->successful() ? $genresResponse->json()['results'] ?? [] : [];

        return view('games.index', [
            'games' => $data['results'] ?? [],
            'total' => $data['count'] ?? 0,
            'search' => $search,
            'genre' => $genre,
            'sortBy' => $sortBy,
            'currentPage' => $page,
            'genres' => $genres,
        ]);
    }

    public function show(string $id)
    {
        $response = Http::get(config('services.rawg.base_url').'/games/'.$id, [
            'key' => config('services.rawg.key'),
        ]);

        if (! $response->successful()) {
            abort(404);
        }

        $game = $response->json();

        $screenshotsResponse = Http::get(config('services.rawg.base_url').'/games/'.$id.'/screenshots', [
            'key' => config('services.rawg.key'),
        ]);

        $screenshots = $screenshotsResponse->successful()
            ? $screenshotsResponse->json()['results'] ?? []
            : [];

        return view('games.show', compact('game', 'screenshots'));
    }
}
