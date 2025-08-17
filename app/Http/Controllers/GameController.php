<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class GameController extends Controller
{
    public function showSingleGame($id)
    {
        $api_key = '925517f17a024b508da64ad9f4d7e388';
        $response = Http::get("https://api.rawg.io/api/games/{$id}?key={$api_key}")->json();

        if (!isset($response['id'])) {
            abort(404, 'Game not found.');
        }

        $game = $response;

        $user = Auth::user();

        $already_added = false;
        $in_wishlist = false;

        if ($user) {
            // Get internal DB ID if this game is already stored
            $game_id = \App\Models\Game::where('db_id', $id)->value('id');

            if ($game_id) {
                $already_added = $user->game()->where('game_id', $game_id)->exists();
                $in_wishlist = $user->gameWishlist()->where('game_id', $game_id)->exists();
            }
        }

        return view('games.singleGame', [
            'game' => $game,
            'exists' => $already_added,
            'in_wishlist' => $in_wishlist,
        ]);
    }


    function addGame(Request $request){

        $validatedData = $request->validate([
            'data_title' => 'required|string|max:255',
            'data_image' => 'required|string|max:255',
            'data_id'    => 'required',
            'data_genres' => 'nullable|string',
        ]);

        $gameTitle = $validatedData['data_title'];
        $gameImage = $validatedData['data_image'];
        $gameId = $validatedData['data_id'];

        // Extract only genre names
        $rawGenres = json_decode($validatedData['data_genres'] ?? '[]', true);

        $genreNames = collect($rawGenres)
            ->pluck('name')
            ->filter()       
            ->unique()
            ->values()
            ->all();        

        $genresJson = json_encode($genreNames); 
        
        $user = Auth::user();

        $game = Game::updateOrCreate(
            ['db_id' => $gameId],
            [
                'title'     => $gameTitle,
                'image_url' => $gameImage,
                'genres'    => $genresJson,
            ]
        );

        if (!$game || !$user) {
            return response()->json([
                'success' => false,
                'message' => 'User or Game not found!',
            ], 404);
        }

        $alreadyAdded = $user->game()->where('game_id', $game->id)->exists();

        if ($alreadyAdded) {
            $user->game()->detach($game->id);
            $message = 'Game removed from your list.';
        } else {
            $user->game()->attach($game->id);
            $message = 'Game added to your list.';
        }

        session()->flash('status', $message);
        return back();

    }

    public function addGameWishlist(Request $request)
    {
        $validatedData = $request->validate([
            'data_title' => 'required|string|max:255',
            'data_image' => 'required|string|max:255',
            'data_id'    => 'required'
        ]);

        $gameTitle = $validatedData['data_title'];
        $gameImage = $validatedData['data_image'];
        $gameDbId  = $validatedData['data_id'];

        $user = Auth::user();

        $game = Game::updateOrCreate([
            'db_id' => $gameDbId,
        ], [
            'title' => $gameTitle,
            'image_url' => $gameImage,
        ]);

        if (!$game || !$user) {
            return response()->json([
                'success' => false,
                'message' => 'User or Game not found!',
            ], 404);
        }

        $alreadyWishlisted = $user->gameWishlist()->where('game_id', $game->id)->exists();

        if ($alreadyWishlisted) {
            $user->gameWishlist()->detach($game->id);
            $message = 'Game removed from your wishlist.';
        } else {
            $user->gameWishlist()->attach($game->id);
            $message = 'Game added to your wishlist.';
        }

        session()->flash('status', $message);

        return back();
    }


    public function showList() {

        $played_games = Game::whereHas('users', function($query) {
            $query->where('user_id', Auth::id());
        })->get();

        $wishlisted = Game::whereHas('wishlist', function($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return view('games/myGamesList', [
            'watched' => $played_games,
            'wishlisted' => $wishlisted
        ]);
    }

    public function deleteGame($id){

        $game = Game::findOrFail($id);

        $game->delete();

        return redirect()->route('my-lists')->with('success', 'Game deleted successfully!');
    }
    
}
