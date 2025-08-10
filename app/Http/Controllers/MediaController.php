<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\Anime;
use App\Models\Game;
use Illuminate\Support\Facades\Cache;

class MediaController extends Controller
{

    //anime
    function topAnimeGlobal(){
        return Cache::remember('top_global_anime', 3600, function () {
            $response = Http::get('https://api.jikan.moe/v4/top/anime')->json();
            return $response['data'];
        });
    }

    function topAnimeAiring()
    {
        return Cache::remember('top_airing_anime', 3600, function () {
            $response = Http::get('https://api.jikan.moe/v4/top/anime', [
                'filter' => 'airing',
                'limit' => 12
            ])->json();

            return $response['data'];
        });
    }

    function topAnimeUpcoming()
    {
        return Cache::remember('top_upcoming_anime', 3600, function () {
            $response = Http::get('https://api.jikan.moe/v4/top/anime', [
                'filter' => 'upcoming'
            ])->json();

            return $response['data'];
        });
    }

    function topAnimeFavorites()
    {
        return Cache::remember('top_favorite_anime', 3600, function () {
            $response = Http::get('https://api.jikan.moe/v4/top/anime', [
                'filter' => 'favorite',
                'limit' => 24
            ])->json();

            return $response['data'];
        });
    }

    function topAnimeCharacters()
    {
        return Cache::remember('top_anime_characters', 3600, function () {
            $response = Http::get('https://api.jikan.moe/v4/top/characters', [
                'limit' => 24
            ])->json();

            return $response['data'];
        });
    }


    function MediaMovies(){
        return Cache::remember('top_rated_movies', 3600, function () {
            $apiKey = '05abd598284193009c38291a6823dd0c';
            $response = Http::get('https://api.themoviedb.org/3/movie/top_rated', [
                'api_key' => $apiKey
            ])->json();
            return $response['results'];
        });
    }

    
    function MediaGames(){
        return Cache::remember('most_popular_games', 3600, function () {
            $api_key = '925517f17a024b508da64ad9f4d7e388';
            $response = Http::get("https://api.rawg.io/api/games?key={$api_key}&ordering=-added")->json();

            return $response['results'];
        });
    }

}