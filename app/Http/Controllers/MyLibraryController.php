<?php

namespace App\Http\Controllers;
use App\Models\{Anime,Movie,Game};
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class MyLibraryController extends Controller
{
    public function index(){

        //anime
        $watched_anime = Auth::user()
            ->anime()
            ->get();

        $wishlisted_anime = Anime::whereHas('wishlist', function($query) {
            $query->where('user_id', Auth::id());
        })->get();

        //movies
        $watched_movies = Auth::user()
            ->movie()
            ->get();

        $wishlisted_movies = Movie::whereHas('wishlist', function($query) {
            $query->where('user_id', Auth::id());
        })->get();

        //games
        $played_games = Auth::user()
            ->game()
            ->get();

        $wishlisted_games = Game::whereHas('wishlist', function($query) {
            $query->where('user_id', Auth::id());
        })->get();


        return view('myLists',[
            'watched_anime' => $watched_anime,
            'wishlisted_anime' => $wishlisted_anime,
            'watched_movies' => $watched_movies,
            'wishlisted_movies' => $wishlisted_movies,
            'played_games' => $played_games,
            'wishlisted_games' => $wishlisted_games
        ]);
    }
}
