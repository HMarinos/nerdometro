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
        
        $apiKEY = '05abd598284193009c38291a6823dd0c';
        $response = Http::get('https://api.themoviedb.org/3/search/movie', [
            'api_key' => $apiKey,
            'query' => 'Inception'
        ])->json();
        dd($response);
    }

    function fetchAndStoreAnime(){

        $response = Http::get('https://api.jikan.moe/v4/anime?q=one')->json();
        dd($response);

    }
    function fetchAndStoreGames(){
        $api_key = '925517f17a024b508da64ad9f4d7e388';
        $response = Http::get("https://api.rawg.io/api/games?key={$api_key}&search=league")->json();
        dd($response);
    }
}