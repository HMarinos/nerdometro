<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    function showSingleMovie($id){
        $apiKey = '05abd598284193009c38291a6823dd0c';
        $response = Http::get('https://api.themoviedb.org/3/movie/19404', [
            'api_key' => $apiKey
        ])->json();
        
        dump($response);
        return view('singleMovie',['movie'=>$response]);
    }
}
