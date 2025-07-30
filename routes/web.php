<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\AnimeSearchController;
use App\Http\Controllers\MovieSearchController;
use App\Http\Controllers\GameSearchController;
use App\Http\Controllers\UserStatsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard']) ->name("dashboard");


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/anime-add', [AnimeController::class, 'addAnime'])->name('anime.add');
    Route::post('/anime-add-wishlist', [AnimeController::class, 'addAnimeWishlist'])->name('anime.add.wishlist');
    Route::delete('/anime-remove-wishlist/{id}', [AnimeController::class, 'removeAnimeWishlist'])->name('anime.remove.wishlist');
    Route::post('/movie-add', [MovieController::class, 'addMovie'])->name('movie.add');
    Route::post('/movie-add-wishlist', [MovieController::class, 'addMovieWishlist'])->name('movie.add.wishlist');
    Route::delete('/movie-remove-wishlist/{id}', [MovieController::class, 'removeMovieWishlist'])->name('movie.remove.wishlist');
    Route::post('/game-add', [GameController::class, 'addGame'])->name('game.add');
    Route::post('/game-add-wishlist', [GameController::class, 'addGameWishlist'])->name('game.add.wishlist');
    Route::delete('/game-remove-wishlist/{id}', [GameController::class, 'removeGameWishlist'])->name('game.remove.wishlist');


    Route::get('/category/anime', [AnimeController::class, 'showList'])->name('anime.list');
    Route::get('/category/movies', [MovieController::class, 'showList'])->name('movies.list');
    Route::get('/category/games', [GameController::class, 'showList'])->name('games.list');
    

    Route::get('/search/anime', [AnimeSearchController::class, 'search'])->name('search.anime');
    Route::get('search/anime/all', [AnimeSearchController::class, 'searchAll'])->name('search.anime.all');

    Route::get('/search/movies', [MovieSearchController::class, 'search'])->name('search.movie');
    Route::get('search/movies/all', [MovieSearchController::class, 'searchAll'])->name('search.movie.all');
    
    Route::get('/search/games', [GameSearchController::class, 'search'])->name('search.games');
    Route::get('/search/games/all', [GameSearchController::class, 'searchAll'])->name('search.games.all');

    //stats 
    Route::get('/stats',[UserStatsController::class, 'userStats'])->name('user.stats');

});

Route::get('/fetch-and-store-movies', [MediaController::class, 'fetchAndStoreMovie']);
Route::get('/fetch-and-store-anime', [MediaController::class, 'fetchAndStoreAnime']);
Route::get('/fetch-and-store-games', [MediaController::class, 'fetchAndStoreGames']);
Route::delete('/anime/{id}', [AnimeController::class, 'deleteAnime'])->name('anime.delete');
Route::delete('/movie/{id}', [MovieController::class, 'deleteMovie'])->name('movie.delete');
Route::delete('/game/{id}', [GameController::class, 'deleteGame'])->name('game.delete');
Route::get('/anime/{id}', [AnimeController::class,'showSingleAnime']);
Route::get('/movie/{id}', [MovieController::class,'showSingleMovie']);
Route::get('/game/{id}', [GameController::class,'showSingleGame']);



require __DIR__.'/auth.php';
