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
        // Pass the response to the view
        return view('category');
    }

    function fetchAndStoreAnime(){
        $response = Http::get('https://api.jikan.moe/v4/top/anime')->json();

        foreach($response['data'] as $item){
            $title = $item['title'];
            echo($title);
        }

    }

    function fetchAndStoreGames(){
        // $ttv_response = Http::post('https://id.twitch.tv/oauth2/token?client_id=bc6zobl5qlfnzw2xhk79cyty02sjmj&client_secret=nfy3sswj9zq23n2i9e28s48tu23ri4&grant_type=client_credentials')->json();
        // $ttv_token = $ttv_response['access_token'];
        // $ttv_client_id = 'bc6zobl5qlfnzw2xhk79cyty02sjmj';
        // $igdb_response = Http::withHeaders([
        //     'Client-ID'=>$ttv_client_id,
        //     'Authorization'=>'Bearer '.$ttv_token,
        // ])->post('https://api.igdb.com/v4/games')->json();
        // dd($ttv_token,$ttv_client_id,$igdb_response);
        $api_key = '925517f17a024b508da64ad9f4d7e388';
        $response = Http::get("https://api.rawg.io/api/games?key={$api_key}")->json();

        dd($response);
    }
}