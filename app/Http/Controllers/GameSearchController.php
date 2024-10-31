<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Game;

class GameSearchController extends Controller
{
    //
    function gameSearch(){

        $api_key = '925517f17a024b508da64ad9f4d7e388';

        $user_input = request('search');
        $top_results = [];

        if($user_input){

            $url = 'https://api.rawg.io/api/games?key=' . $api_key . '&search=' . $user_input;
            $response = Http::get($url)->json();

            foreach(array_slice($response['results'],0,10) as $result){
                array_push($top_results,$result['name']);
            }
            
            dump($top_results);
        }

        $getGame = Game::all();

        dump($getGame);

        return view('category',["game_results"=>$top_results,"game_data"=>$getGame]);
    }
}
