<?php

use App\Http\Controllers\Api\GameController;
use Illuminate\Support\Facades\Route;

Route::get('/games/safe', [GameController::class, 'safe'])->name('api.games.safe');
Route::get('/games/{id}', [GameController::class, 'show'])->name('api.games.show');
