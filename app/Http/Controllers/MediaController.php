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
        for ($page = 1; $page <= 10; $page++) {
            $response = Http::get('https://api.jikan.moe/v4/top/manga', ['page' => $page])->json();
            
            foreach($response['data'] as $item){
                echo $item['title'];
                echo "<br>";
            }

            // if (isset($response['data'])) {
            //     foreach ($response['data'] as $item) {
            //         echo $item['title'];
            //         echo "<br>";
            //     }
            // } else {
            //     echo "No data found for page $page<br>";
            // }
        }

        // foreach($response['data'] as $item){
        //     $title = $item['title'];
        //     Anime::create([
        //         'title'=>$title,
        //     ]);
        // }

    }

    function fetchAndStoreGames(){
        $api_key = '925517f17a024b508da64ad9f4d7e388';
        $response = Http::get("https://api.rawg.io/api/games?key={$api_key}")->json();
        // dd($response['results']);
        foreach ($response['results'] as $item){
            $title = $item['name'];
            Game::create([
                'title'=>$title,
            ]);
        }

    }
}