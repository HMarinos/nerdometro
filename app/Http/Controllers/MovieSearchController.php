<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;

class MovieSearchController extends Controller
{
    //
    function movieSearch(){

        $apiKey = '05abd598284193009c38291a6823dd0c';

        $user_input = request('search');
        $top_results = [];

        if($user_input){
            $url = 'https://api.themoviedb.org/3/search/movie?api_key=' . $apiKey . '&query=' . $user_input ;
            $response = Http::get($url)->json();

            foreach(array_slice($response['results'],0,10) as $result){
                array_push($top_results,$result['title']);
            }

            dump($top_results);
        }

        $getMovie = Movie::all();

        dump($getMovie);

        return view('category',["movie_results"=>$top_results,"movie_data"=>$getMovie]);

    }
}
