<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForumPostController;
use App\Http\Controllers\ForumReplyController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Services\RawgService;
use App\Services\SteamService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function (RawgService $rawg, SteamService $steam) {
    $data = Cache::remember('homepage_data', 1800, function () use ($rawg, $steam) {
        try {
            $genres = array_slice($rawg->getGenres(), 0, 6);
        } catch (ConnectionException) {
            $genres = [];
        }

        try {
            $trendingData = $rawg->getGames(['ordering' => '-added', 'page_size' => 3]);
            $trendingGames = $trendingData['results'] ?? [];
        } catch (ConnectionException) {
            $trendingGames = [];
        }

        try {
            $heroData = $rawg->getGames(['ordering' => '-added', 'page_size' => 3, 'dates' => '2023-01-01,2026-12-31']);
            $heroGames = $heroData['results'] ?? [];
        } catch (ConnectionException) {
            $heroGames = [];
        }

        $newsItems = [];
        $seenAppIds = [];

        foreach ($trendingGames as $game) {
            try {
                $detail = $rawg->getGame($game['id']);
                $appId = $detail['steam_app_id'] ?? null;
                if ($appId && ! in_array($appId, $seenAppIds)) {
                    $seenAppIds[] = $appId;
                    $gameNews = $steam->getNewsForApp($appId, 2, 200);
                    if ($gameNews && count($gameNews) > 0) {
                        $newsItems[] = [
                            'game_id' => $game['id'],
                            'game_name' => $game['name'],
                            'game_image' => $game['background_image'] ?? null,
                            'news' => $gameNews,
                        ];
                    }
                }
            } catch (ConnectionException) {
                continue;
            }
        }

        if (empty($newsItems)) {
            $fallbackAppIds = [730, 570, 440, 578080, 1085660, 252490, 105600, 431960];
            foreach ($fallbackAppIds as $appId) {
                $gameNews = $steam->getNewsForApp($appId, 2, 200);
                if ($gameNews && count($gameNews) > 0) {
                    $appDetails = $steam->getAppDetails($appId);
                    $newsItems[] = [
                        'game_id' => null,
                        'game_name' => $appDetails['name'] ?? null,
                        'game_image' => $appDetails['header_image'] ?? null,
                        'news' => $gameNews,
                    ];
                }
                if (count($newsItems) >= 3) {
                    break;
                }
            }
        }

        return compact('genres', 'trendingGames', 'heroGames', 'newsItems');
    });

    return view('welcome', [
        'genres' => collect($data['genres']),
        'trendingGames' => $data['trendingGames'],
        'heroGames' => $data['heroGames'],
        'newsItems' => collect($data['newsItems']),
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->middleware('can:admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::patch('/users/{user}/update-role', [AdminUserController::class, 'updateRole'])->name('admin.users.update-role');
        Route::patch('/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('admin.users.suspend');
        Route::patch('/users/{user}/unsuspend', [AdminUserController::class, 'unsuspend'])->name('admin.users.unsuspend');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::get('/games/search', [GameController::class, 'search'])->name('games.search');
    Route::get('/games/{id}', [GameController::class, 'show'])->name('games.show');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::post('/wishlist/add-from-game/{gameId}', [WishlistController::class, 'addFromGame'])->name('wishlist.add-from-game');
    Route::patch('/wishlist/{wishlistItem}', [WishlistController::class, 'update'])->name('wishlist.update');
    Route::delete('/wishlist/{wishlistItem}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    Route::get('/forum', [ForumPostController::class, 'index'])->name('forum.index');
    Route::get('/forum/create', [ForumPostController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumPostController::class, 'store'])->name('forum.store');
    Route::get('/forum/{forumPost}', [ForumPostController::class, 'show'])->name('forum.show');
    Route::get('/forum/{forumPost}/edit', [ForumPostController::class, 'edit'])->name('forum.edit');
    Route::patch('/forum/{forumPost}', [ForumPostController::class, 'update'])->name('forum.update');
    Route::delete('/forum/{forumPost}', [ForumPostController::class, 'destroy'])->name('forum.destroy');

    Route::post('/forum/{forumPost}/replies', [ForumReplyController::class, 'store'])->name('replies.store');
    Route::get('/replies/{forumReply}/edit', [ForumReplyController::class, 'edit'])->name('replies.edit');
    Route::patch('/replies/{forumReply}', [ForumReplyController::class, 'update'])->name('replies.update');
    Route::delete('/replies/{forumReply}', [ForumReplyController::class, 'destroy'])->name('replies.destroy');
});

require __DIR__.'/auth.php';
