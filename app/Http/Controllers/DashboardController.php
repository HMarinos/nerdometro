<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MediaController;
use App\Models\Anime;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $mediaController = new MediaController();
        $movies = $mediaController-> fetchAndStoreMovie();
        $anime = $mediaController-> fetchAndStoreAnime();
        $games = $mediaController-> fetchAndStoreGames();

        return view('dashboard', compact('movies', 'anime', 'games'));
    }
}
