<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnimeSearchController extends Controller
{
    //
    function animeSearch(){
        $url = 'https://api.jikan.moe/v4/anime?q=dragonb' ;
        $response = Http::get($url)->json();
        dump($response);
        // return view('singleAnime',['anime'=> $anime]);
    }
}
