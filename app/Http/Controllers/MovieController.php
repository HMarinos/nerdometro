<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;


class MovieController extends Controller
{
    function showSingleMovie($id){
        $apiKey = '05abd598284193009c38291a6823dd0c';
        $response = Http::get('https://api.themoviedb.org/3/movie/'. $id, [
            'api_key' => $apiKey
        ])->json();
        $response_video = Http::get('https://api.themoviedb.org/3/movie/' . $id . '/videos', [
            'api_key' => $apiKey
        ])->json();
        $release_dates = Http::get('https://api.themoviedb.org/3/movie/' . $id . '/release_dates', [
            'api_key' => $apiKey
        ])->json();


        $objects = $response_video['results'];
        
        $firstTrailerObject = null;

        foreach ($objects as $object) {
            if ($object['type'] === "Trailer") {
                $firstTrailerObject = $object;
                break; 
            }
        }
        // dump($firstTrailerObject);
        
        return view('singleMovie',['movie'=>$response,'video'=>$firstTrailerObject]);
    }

    function addMovie(Request $request){

        $validateData = $request->validate([
            'value' => 'required|string|max:255',
        ]);

        $movieTitle = $validateData['value'];
        $user = Auth::user();
        //Create a new Movie model instance
        $movie = Movie::firstOrCreate(['title'=>$movieTitle]);

        if($movie && $user){
            $user->movie()->attach($movie->id);

            return response()->json([
                'success' => true,
                'message' => 'Movie added successfully!'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'User or Movie not found!',
        ], 404);
        
    }
}
