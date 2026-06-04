<?php

namespace App\Http\Controllers;

use App\Models\WishlistItem;
use App\Services\RawgService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct(
        protected RawgService $rawg,
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

        $data = $this->rawg->getGames($params);

        $genres = $this->rawg->getGenres();

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

    public function search(Request $request)
    {
        $query = $request->input('q');

        if (strlen((string) $query) < 2) {
            return response()->json([]);
        }

        $data = $this->rawg->getGames([
            'search' => $query,
            'search_precise' => true,
            'page_size' => 8,
        ]);

        return response()->json($data['results'] ?? []);
    }

    public function show(string $id)
    {
        $game = $this->rawg->getGame($id);

        if ($game === null) {
            abort(404);
        }

        $screenshots = $this->rawg->getScreenshots($id);

        $inWishlist = auth()->check()
            ? WishlistItem::where('user_id', auth()->id())
                ->where('rawg_game_id', $id)
                ->exists()
            : false;

        return view('games.show', compact('game', 'screenshots', 'inWishlist'));
    }
}
