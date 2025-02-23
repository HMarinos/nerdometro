<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Anime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AnimeController extends Controller
{
    public function showSingleAnime($id){
        $url = 'https://api.jikan.moe/v4/anime/' . $id . '/full';
        $response = Http::get($url)->json();
        $anime = $response['data'];

        return view('singleAnime',['anime'=> $anime]);
    }

    public function addAnime(Request $request){
        
        $validatedData = $request->validate([
            'data_title' => 'required|string|max:255',
            'data_image' => 'required|string|max:255',
            'data_id'    => 'required'
        ]);

    
        $animeTitle = $validatedData['data_title'];
        $animeImage = $validatedData['data_image'];
        $animeId = $validatedData['data_id'];

        $user = Auth::user();   
        $anime = Anime::updateOrCreate([
            'title' => $animeTitle,
            'image_url' => $animeImage,
            'db_id' => $animeId
        ]);


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
    
    public function deleteAnime($id){

        $anime = Anime::findOrFail($id);

        $anime->delete();

        return redirect()->route('category.show',['category'=>'anime'])->with('success', 'Anime deleted successfully!');
    }
}
