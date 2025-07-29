<?php

use Illuminate\Support\Facades\Route;

Route::prefix('movies')->group(function () {
    Route::get('/', [\App\Domains\Movies\Http\Controllers\MovieController::class, 'index'])
        ->name('movies.index');

        Route::get('/popular-with-favorites', [\App\Domains\Movies\Http\Controllers\MovieController::class, 'popularWithFavorites'])
        ->name('movies.favorites.popular_with_favorites');
});

Route::prefix('movies')->group(function () {
    Route::get('/add-favorites', [\App\Domains\Movies\Http\Controllers\MovieFavoriteController::class, 'index'])
        ->name('movies.favorites.index');

    Route::post('/add-favorites', [\App\Domains\Movies\Http\Controllers\MovieFavoriteController::class, 'store'])
        ->name('movies.favorites.store');

    Route::delete('/favorites/{tmdb_id}', [\App\Domains\Movies\Http\Controllers\MovieFavoriteController::class, 'destroy'])
        ->name('movies.favorites.destroy');
});
