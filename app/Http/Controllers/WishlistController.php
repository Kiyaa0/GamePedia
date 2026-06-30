<?php

namespace App\Http\Controllers;

use App\Models\WishlistItem;
use App\Services\RawgService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function __construct(
        protected RawgService $rawg,
    ) {}

    public function index(Request $request): View
    {
        $userId = auth()->id();

        $stats = [
            'total' => WishlistItem::where('user_id', $userId)->count(),
            'want_to_buy' => WishlistItem::where('user_id', $userId)->where('status', 'want_to_buy')->count(),
            'playing' => WishlistItem::where('user_id', $userId)->where('status', 'playing')->count(),
            'owned' => WishlistItem::where('user_id', $userId)->where('status', 'owned')->count(),
        ];

        $query = WishlistItem::where('user_id', $userId);

        if ($request->filled('status') && in_array($request->status, ['want_to_buy', 'playing', 'owned'])) {
            $query->where('status', $request->status);
        }

        $items = $query->latest()->paginate(12);

        return view('wishlist.index', compact('items', 'stats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'rawg_game_id' => ['required', 'string'],
            'game_title' => ['required', 'string', 'max:255'],
            'game_image' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:want_to_buy,owned,playing'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $exists = WishlistItem::where('user_id', auth()->id())
            ->where('rawg_game_id', $validated['rawg_game_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Game already in your wishlist.');
        }

        WishlistItem::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('wishlist.index')->with('success', 'Game added to wishlist!');
    }

    public function update(Request $request, WishlistItem $wishlistItem): RedirectResponse
    {
        $this->authorize('update', $wishlistItem);

        $validated = $request->validate([
            'status' => ['required', 'in:want_to_buy,owned,playing'],
        ]);

        $wishlistItem->update($validated);

        return redirect()->route('wishlist.index')->with('success', 'Wishlist updated!');
    }

    public function destroy(WishlistItem $wishlistItem): RedirectResponse
    {
        $this->authorize('delete', $wishlistItem);

        $wishlistItem->delete();

        return redirect()->route('wishlist.index')->with('success', 'Game removed from wishlist.');
    }

    public function addFromGame(Request $request, string $gameId): RedirectResponse
    {
        try {
            $game = $this->rawg->getGame($gameId);
        } catch (ConnectionException) {
            return back()->with('error', 'Gagal terhubung ke server game. Silakan coba lagi.');
        }

        if ($game === null) {
            return back()->with('error', 'Game not found.');
        }

        $exists = WishlistItem::where('user_id', auth()->id())
            ->where('rawg_game_id', $gameId)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Game already in your wishlist.');
        }

        WishlistItem::create([
            'user_id' => auth()->id(),
            'rawg_game_id' => $gameId,
            'game_title' => $game['name'],
            'game_image' => $game['background_image'] ?? null,
            'status' => 'want_to_buy',
        ]);

        return redirect()->route('wishlist.index')->with('success', 'Game added to wishlist!');
    }
}
