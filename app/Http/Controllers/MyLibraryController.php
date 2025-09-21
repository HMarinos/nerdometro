<?php

namespace App\Http\Controllers;
use App\Models\{Anime,Movie,Game};
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class MyLibraryController extends Controller
{
public function index(Request $request)
{
    if ($request->has('active_tab')) {
        session(['active_tab' => $request->input('active_tab')]);
    }
    
    $animeSort = $request->query('anime_sort', 'alphabetical');
    $animeOrder = $request->query('anime_order', 'asc');
    $movieSort = $request->query('movie_sort', 'alphabetical');
    $movieOrder = $request->query('movie_order', 'asc');
    $gameSort = $request->query('game_sort', 'alphabetical');
    $gameOrder = $request->query('game_order', 'asc');

    //anime
    $watched_anime = Auth::user()->anime()->get();
    $watched_anime = $this->sortMedia($watched_anime, $animeSort, $animeOrder);

    $wishlisted_anime = Anime::whereHas('wishlist', function($query) {
        $query->where('user_id', Auth::id());
    })->get();

    //movies
    $watched_movies = Auth::user()->movie()->get();
    $watched_movies = $this->sortMedia($watched_movies, $movieSort, $movieOrder);

    $wishlisted_movies = Movie::whereHas('wishlist', function($query) {
        $query->where('user_id', Auth::id());
    })->get();

    //games
    $played_games = Auth::user()->game()->get();
    $played_games = $this->sortMedia($played_games, $gameSort, $gameOrder);

    $wishlisted_games = Game::whereHas('wishlist', function($query) {
        $query->where('user_id', Auth::id());
    })->get();

    return view('myLists',[
        'watched_anime' => $watched_anime,
        'wishlisted_anime' => $wishlisted_anime,
        'watched_movies' => $watched_movies,
        'wishlisted_movies' => $wishlisted_movies,
        'played_games' => $played_games,
        'wishlisted_games' => $wishlisted_games,
        'animeSort' => $animeSort,
        'animeOrder' => $animeOrder,
        'movieSort' => $movieSort,
        'movieOrder' => $movieOrder,
        'gameSort' => $gameSort,
        'gameOrder' => $gameOrder,
    ]);
}

private function sortMedia($collection, $sort, $order = 'asc')
{
    $desc = $order === 'desc';

    switch ($sort) {
        case 'user_rating':
            return $desc
                ? $collection->sortByDesc(fn($item) => $item->pivot->user_rating ?? 0)
                : $collection->sortBy(fn($item) => $item->pivot->user_rating ?? 0);
        case 'rating':
            return $desc
                ? $collection->sortByDesc('rating')
                : $collection->sortBy('rating');
        case 'alphabetical':
        default:
            return $desc
                ? $collection->sortByDesc('title')
                : $collection->sortBy('title');
    }
}
}
