<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MediaController extends Controller
{
    function fetchAndStoreMovie(){
        $apiKEY = '05abd598284193009c38291a6823dd0c';
        $response = Http::get('https://api.themoviedb.org/3/movie/popular', ['api_key' => $apiKEY])->json();
        dd($response);
    }

    function fetchAndStoreAnime(){
        $response = Http::get('https://api.jikan.moe/v4/top/anime')->json();

        foreach($response['data'] as $item){
            $title = $item['title'];
            echo($title);
        }

    }

    function fetchAndStoreGames(){
        $api_key = '925517f17a024b508da64ad9f4d7e388';
        $response = Http::get("https://api.rawg.io/api/games?key={$api_key}")->json();
        dd($response);
    }
}