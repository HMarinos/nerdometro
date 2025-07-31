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
    function fetchAndStoreMovie(){
        return Cache::remember('top_rated_movies', 3600, function () {
            $apiKey = '05abd598284193009c38291a6823dd0c';
            $response = Http::get('https://api.themoviedb.org/3/movie/top_rated', [
                'api_key' => $apiKey
            ])->json();
            return $response['results'];
        });
    }

    function fetchAndStoreAnime(){
        return Cache::remember('top_rated_anime', 3600, function () {
            $response = Http::get('https://api.jikan.moe/v4/top/anime')->json();
            return $response['data'];
        });
    }
    
    function fetchAndStoreGames(){
        return Cache::remember('most_popular_games', 3600, function () {
            $api_key = '925517f17a024b508da64ad9f4d7e388';
            $response = Http::get("https://api.rawg.io/api/games?key={$api_key}&ordering=-added")->json();

            return $response['results'];
        });
    }

}