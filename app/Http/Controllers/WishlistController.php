<?php

namespace App\Http\Controllers;

use App\Models\WishlistItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $items = WishlistItem::where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('wishlist.index', compact('items'));
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
        $response = Http::get(config('services.rawg.base_url').'/games/'.$gameId, [
            'key' => config('services.rawg.key'),
        ]);

        if (! $response->successful()) {
            return back()->with('error', 'Game not found.');
        }

        $game = $response->json();

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
