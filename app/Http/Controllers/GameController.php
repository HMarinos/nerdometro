<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    function showSingleGame($id){

        $api_key = '925517f17a024b508da64ad9f4d7e388';
        $response = Http::get("https://api.rawg.io/api/games/{$id}?key={$api_key}")->json();
        // dump($response);
        return view('singleGame',['game'=>$response]);
    }

    function addGame(Request $request){

        $validatedData = $request->validate([
            'value' => 'required|string|max:255', // Validation rules
        ]);

        $gameTitle = $validatedData['value'];
        $user = Auth::user();

        // Create a new Game model instance
        $game = Game::firstOrCreate(['title' => $gameTitle]);

        if($game && $user){
            $user->game()->attach($game->id);

            return response()->json([
                'success' => true,
                'message' => 'Game added successfully!',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'User or Game not found!',
        ], 404);
    }
    
}