<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GamesController extends Controller
{
    function showSingleGame($id){

        $api_key = '925517f17a024b508da64ad9f4d7e388';
        $response = Http::get("https://api.rawg.io/api/games/{$id}?key={$api_key}")->json();
        // dump($response);
        return view('singleGame',['game'=>$response]);
    }
}
