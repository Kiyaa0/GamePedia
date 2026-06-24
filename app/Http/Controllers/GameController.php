<?php

namespace App\Http\Controllers;

use App\Models\WishlistItem;
use App\Services\RawgService;
use App\Services\SteamService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct(
        protected RawgService $rawg,
        protected SteamService $steam,
    ) {}

    public function index(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $genre = $request->input('genre');
        $sortBy = $request->input('sort', '');

        $params = ['page' => $page];

        if ($sortBy !== '') {
            $params['ordering'] = $sortBy;
        }

        if ($search) {
            $params['search'] = $search;
            $params['search_precise'] = true;
        }

        if ($genre) {
            $params['genres'] = $genre;
        }

        try {
            $data = $this->rawg->getGames($params);
            $genres = $this->rawg->getGenres();
        } catch (ConnectionException $e) {
            return back()->with('error', 'Gagal terhubung ke server game. Silakan coba lagi.');
        }

        return view('games.index', [
            'games' => $data['results'] ?? [],
            'total' => $data['count'] ?? 0,
            'search' => $search,
            'genre' => $genre,
            'sortBy' => $sortBy,
            'currentPage' => $page,
            'genres' => $genres ?? [],
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        if (strlen((string) $query) < 2) {
            return response()->json([]);
        }

        try {
            $data = $this->rawg->getGames([
                'search' => $query,
                'search_precise' => true,
                'page_size' => 8,
            ]);
        } catch (ConnectionException $e) {
            return response()->json([], 503);
        }

        return response()->json($data['results'] ?? []);
    }

    public function show(string $id)
    {
        try {
            $game = $this->rawg->getGame($id);
        } catch (ConnectionException $e) {
            return back()->with('error', 'Gagal memuat detail game. Silakan coba lagi.');
        }

        if ($game === null) {
            abort(404);
        }

        try {
            $screenshots = $this->rawg->getScreenshots($id);
        } catch (ConnectionException $e) {
            $screenshots = [];
        }

        $inWishlist = auth()->check()
            ? WishlistItem::where('user_id', auth()->id())
                ->where('rawg_game_id', $id)
                ->exists()
            : false;

        $steamAppId = $game['steam_app_id'] ?? null;
        $playerCount = $this->steam->getCurrentPlayers($steamAppId);

        return view('games.show', compact('game', 'screenshots', 'inWishlist', 'playerCount', 'steamAppId'));
    }
}
