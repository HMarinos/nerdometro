<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    function fetchAndStoreMovie(){
        $apiKEY = '05abd598284193009c38291a6823dd0c';
        $response = Http::get('https://api.themoviedb.org/3/movie/popular', ['api_key' => $apiKEY])->json();
        dd($response);
        // Pass the response to the view
        return view('category');
    }
}