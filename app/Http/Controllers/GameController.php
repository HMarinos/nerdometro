<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class GameController extends Controller
{
    function showSingleGame($id){

        $api_key = '925517f17a024b508da64ad9f4d7e388';
        $response = Http::get("https://api.rawg.io/api/games/{$id}?key={$api_key}")->json();

        return view('singleGame',['game'=>$response]);
    }

    function addGame(Request $request){

        $validatedData = $request->validate([
            'data_title' => 'required|string|max:255',
            'data_image' => 'required|string|max:255',
            'data_id'    => 'required'
        ]);

        $animeTitle = $validatedData['data_title'];
        $animeImage = $validatedData['data_image'];
        $animeId = $validatedData['data_id'];
        
        $user = Auth::user();

        $game = Game::updateOrCreate([
            'title' => $animeTitle,
            'image_url' => $animeImage,
            'db_id' => $animeId
        ]);

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

    public function deleteGame($id){

        $game = Game::findOrFail($id);

        $game->delete();

        return redirect()->route('category.show',['category'=>'games'])->with('success', 'Game deleted successfully!');
    }
    
}
