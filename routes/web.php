<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\DashboardController;
use App\Http\controllers\AnimeController;
use App\Http\controllers\MovieController;
use App\Http\controllers\GameController;
use App\Http\controllers\AnimeSearchController;
use App\Http\controllers\MovieSearchController;
use App\Http\controllers\GameSearchController;

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
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard']) ->name("dashboard");


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/anime-add', [AnimeController::class, 'addAnime'])->name('anime.add');
    Route::post('/anime-add-wishlist', [AnimeController::class, 'addAnimeWishlist'])->name('anime.add.wishlist');
    Route::post('/movie-add', [MovieController::class, 'addMovie'])->name('movie.add');
    Route::post('/game-add', [GameController::class, 'addGame'])->name('game.add');

    // Route::get('/category/{category}', function($category){
    //     return view('category',['category'=>$category]);
    // })->name('category.show');

    Route::get('/category/anime', [AnimeController::class, 'showList'])->name('anime.list');


    Route::get('/search/anime', [AnimeSearchController::class, 'search'])->name('search.anime');
    Route::get('/search/movies', [MovieSearchController::class, 'search'])->name('search.movies');
    Route::get('/search/games', [GameSearchController::class, 'search'])->name('search.games');

});

Route::get('/fetch-and-store-movies', [MediaController::class, 'fetchAndStoreMovie']);
Route::get('/fetch-and-store-anime', [MediaController::class, 'fetchAndStoreAnime']);
Route::get('/fetch-and-store-games', [MediaController::class, 'fetchAndStoreGames']);
Route::get('/fetch-and-store-games', [MediaController::class, 'fetchAndStoreGames']);
Route::delete('/anime/{id}', [AnimeController::class, 'deleteAnime'])->name('anime.delete');
Route::delete('/movie/{id}', [MovieController::class, 'deleteMovie'])->name('movie.delete');
Route::delete('/game/{id}', [GameController::class, 'deleteGame'])->name('game.delete');
Route::get('/anime/{id}', [AnimeController::class,'showSingleAnime']);
Route::get('/movie/{id}', [MovieController::class,'showSingleMovie']);
Route::get('/game/{id}', [GameController::class,'showSingleGame']);



require __DIR__.'/auth.php';
