<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Anime;

class AnimeSearchController extends Controller
{
    //
    function animeSearch(){

        $user_input = request('search');
        $top_results = [];


        if($user_input){
            $url = 'https://api.jikan.moe/v4/anime?q='. $user_input ;
            $response = Http::get($url)->json();

            // dump($response);
            
            foreach(array_slice($response['data'],0,10) as $result){
                array_push($top_results, [
                    'title' => $result['title'],
                    'image_url' => $result['images']['webp']['image_url'],
                    'db_id' => $result['mal_id']
                ]);
            }
        }

        $getAnime = Anime::all();

        // dump($getAnime);
        
        return view('category',["anime_results"=>$top_results,"anime_data"=>$getAnime]);
    }
    

}
