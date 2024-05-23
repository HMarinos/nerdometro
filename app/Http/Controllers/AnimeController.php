<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Anime;



class AnimeController extends Controller
{
    function showSingleAnime($id){
        $url = 'https://api.jikan.moe/v4/anime/' . $id . '/full';
        $response = Http::get($url)->json();
        $anime = $response['data'];

        
        // dump($anime);
        return view('singleAnime',['anime'=> $anime]);
    }

    public function addTestAnime()
    {
        // Create a new anime record in the anime_list table with title 'test'
        Anime::create([
            'title' => 'test', // Set the title to 'test'
            // Optionally, you can set other fields here such as genre and date
        ]);

    }
    
}
