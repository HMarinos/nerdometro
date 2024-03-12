<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AnimeController extends Controller
{
    function showSingleAnime(){
        $response = Http::get('https://api.jikan.moe/v4/anime/52991/full')->json();
        $anime = $response['data'];
        dump($anime);
        // return view('single');
    }
}
