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
