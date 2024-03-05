<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\Anime;
use App\Models\Game;

class MediaController extends Controller
{
    function fetchAndStoreMovie(){
        $apiKey = '05abd598284193009c38291a6823dd0c';
        $response = Http::get('https://api.themoviedb.org/3/movie/top_rated', [
            'api_key' => $apiKey
            // 'query' => 'incept'
        ])->json();
        $movies = $response['results'];
        // dump($movies);
        return $movies;
    }

    function fetchAndStoreAnime(){
        $response = Http::get('https://api.jikan.moe/v4/top/anime')->json();
        $anime = $response['data'];
        // dump($anime);
        return $anime;
    }
    
    function fetchAndStoreGames(){
        $api_key = '925517f17a024b508da64ad9f4d7e388';
        $response = Http::get("https://api.rawg.io/api/games?key={$api_key}&ordering=-rating")->json();
        $games = $response['results'];
        // dump($games);
        return $games;
    }
}