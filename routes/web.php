<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnimeController;

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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'dashboard']) ->name("dashboard");


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/category/{category}', function () {
        return view('category');
    });
    Route::get('/anime-single',[AnimeController::class,'showSingleAnime']);
});



Route::get('/fetch-and-store-movies', [MediaController::class, 'fetchAndStoreMovie']);
Route::get('/fetch-and-store-anime', [MediaController::class, 'fetchAndStoreAnime']);
Route::get('/fetch-and-store-games', [MediaController::class, 'fetchAndStoreGames']);
Route::get('/fetch-and-store-games', [MediaController::class, 'fetchAndStoreGames']);

require __DIR__.'/auth.php';
