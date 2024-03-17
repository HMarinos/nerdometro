<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



class AnimeController extends Controller
{
    function showSingleAnime($id){
        $url = 'https://api.jikan.moe/v4/anime/' . $id . '/full';
        $response = Http::get($url)->json();
        $anime = $response['data'];
        dump($anime);
        return view('singleAnime',['anime'=> $anime]);
    }
    
}
