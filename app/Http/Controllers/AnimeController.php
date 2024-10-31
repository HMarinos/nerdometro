<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Anime;
use Illuminate\Support\Facades\Auth;




class AnimeController extends Controller
{
    function showSingleAnime($id){
        $url = 'https://api.jikan.moe/v4/anime/' . $id . '/full';
        $response = Http::get($url)->json();
        $anime = $response['data'];

            
        // dump($anime);
        return view('singleAnime',['anime'=> $anime]);
    }

    function addAnime(Request $request){

        $validatedData = $request->validate([
            'value' => 'required|string|max:255', // Validation rules
        ]);
    
        $animeTitle = $validatedData['value'];
        $user = Auth::user();   
        // Create a new Anime model instance
        $anime = Anime::firstOrCreate(['title' => $animeTitle]);


        if($anime && $user){
            $user->anime()->attach($anime->id);

            return response()->json([
                'success' => true,
                'message' => 'Anime added successfully!',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'User or Anime not found!',
        ], 404);
    }
}
