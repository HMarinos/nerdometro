<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnimeSearchController extends Controller
{
    //
    function animeSearch(){

        $user_input = request('search');
        $top_results = [];


        if($user_input){
            $url = 'https://api.jikan.moe/v4/anime?q='. $user_input ;
            $response = Http::get($url)->json();
            
            foreach(array_slice($response['data'],0,10) as $result){
                array_push($top_results,$result['title']);
            }
            dump($top_results);

        }
        return view('category',["anime_results"=>$top_results]);
    }

}
