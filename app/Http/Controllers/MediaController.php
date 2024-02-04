<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;

class MediaController extends Controller
{
    function fetchAndStoreMovie(){
        $apiKEY = '05abd598284193009c38291a6823dd0c';
        // $response = Http::get('https://api.themoviedb.org/3/movie/top_rated', ['api_key' => $apiKEY, 'page'=>1])->json();
        $titles = [];
        for ($page = 1; $page <= 10; $page++) {
            $response = Http::get('https://api.themoviedb.org/3/movie/top_rated', ['api_key' => $apiKEY, 'page' => $page])->json(); 
            $titles = array_merge($titles, array_column($response['results'], 'title'));
        }
        foreach ($titles as $title) {
            Movie::create([
                'title' => $title,
            ]);
        }



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