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

        $user = Auth::user();   

        // dump($anime);

        //check if the anime is already added
        $anime_id = Anime::where('db_id', $id)->value('id');
        $already_added = $user->anime()->where('anime_id', $anime_id)->exists();
        $in_wishlist = $user->wishlist()->where('anime_id', $anime_id)->exists();

        return view('/anime/singleAnime',[
            'anime'=> $anime,
            'exists' => $already_added,
            'in_wishlist' => $in_wishlist
        ]);
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

        if (!$anime || !$user) {
            return response()->json([
                'success' => false,
                'message' => 'User or Anime not found!',
            ], 404);
        }

        $already_added = $user->anime()->where('anime_id', $anime->id)->exists();


        if ($already_added) {
            $user->anime()->detach($anime->id);
            $message = 'Anime removed from your list.';
        } else {
            $user->anime()->attach($anime->id);
            $message = 'Anime added to your list.';
        }
    
        session()->flash('status', $message);

        // Return a redirect back to the current page (refresh)
        return back();

    }

    public function addAnimeWishlist(Request $request){

        $validatedData = $request->validate([
            'data_title' => 'required|string|max:255',
            'data_image' => 'required|string|max:255',
            'data_id'    => 'required'
        ]);
    
        $animeTitle = $validatedData['data_title'];
        $animeImage = $validatedData['data_image'];
        $animeDbId  = $validatedData['data_id'];
    
        $user = Auth::user();
    
        $anime = Anime::updateOrCreate([
            'db_id' => $animeDbId,
        ], [
            'title' => $animeTitle,
            'image_url' => $animeImage,
        ]);
    
        if (!$anime || !$user) {
            return response()->json([
                'success' => false,
                'message' => 'User or Anime not found!',
            ], 404);
        }
    
        $alreadyWishlisted = $user->wishlist()->where('anime_id', $anime->id)->exists();
    
        if ($alreadyWishlisted) {
            $user->wishlist()->detach($anime->id);
            $message = 'Anime removed from your wishlist.';
        } else {
            $user->wishlist()->attach($anime->id);
            $message = 'Anime added to your wishlist.';
        }
    
        session()->flash('status', $message);
    
        return back();
    }

    public function removeAnimeWishlist($id) {
        $user = Auth::user();
        $anime = Anime::findOrFail($id);

        if ($user->wishlist()->where('anime_id', $anime->id)->exists()) {
            $user->wishlist()->detach($anime->id);
            session()->flash('status', 'Anime removed from your wishlist.');
        } else {
            session()->flash('status', 'Anime not found in your wishlist.');
        }

        return back();
    }

    public function showList() {

        $watched_anime = Anime::whereHas('users', function($query) {
            $query->where('user_id', Auth::id());
        })->get();

        $wishlisted = Anime::whereHas('wishlist', function($query) {
            $query->where('user_id', Auth::id());
        })->get();


        return view('anime/myAnimeList',[
            'watched' => $watched_anime,
            'wishlisted' => $wishlisted
        ]);
    }
    
    
    public function deleteAnime($id){

        $anime = Anime::findOrFail($id);
        $user = auth()->user(); 

        $user->anime()->detach($anime->id);

        return redirect()->route('anime.list')->with('success', 'Anime deleted successfully!');
    }
}
