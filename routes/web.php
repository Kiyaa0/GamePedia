<?php

use App\Http\Controllers\ForumPostController;
use App\Http\Controllers\ForumReplyController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
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
