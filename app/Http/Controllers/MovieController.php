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

        $user = Auth::user();
        $movie_id = Movie::where('db_id', $id)->value('id');
        $already_added = $user && $movie_id ? $user->movie()->where('movie_id', $movie_id)->exists() : false;
        $in_wishlist = $user && $movie_id ? $user->movieWishlist()->where('movie_id', $movie_id)->exists() : false;

        // dd($response);

        return view('/movies/singleMovie', [
            'movie' => $response,
            'video' => $firstTrailerObject,
            'exists' => $already_added,
            'in_wishlist' => $in_wishlist
        ]);
    }

    function addMovie(Request $request){

        $validateData = $request->validate([
            'data_title' => 'required|string|max:255',
            'data_image' => 'required|string|max:255',
            'data_id'    => 'required'
        ]);

        $movieTitle = $validateData['data_title'];
        $movieImage = $validateData['data_image'];
        $movieId = $validateData['data_id'];

        $user = Auth::user();
        $movie = Movie::updateOrCreate([
            'title' => $movieTitle,
            'image_url' => $movieImage,
            'db_id' => $movieId
        ]);

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

    public function addMovieWishlist(Request $request)
    {
        $validatedData = $request->validate([
            'data_title' => 'required|string|max:255',
            'data_image' => 'required|string|max:255',
            'data_id'    => 'required'
        ]);

        $movieTitle = $validatedData['data_title'];
        $movieImage = $validatedData['data_image'];
        $movieDbId  = $validatedData['data_id'];

        $user = Auth::user();

        $movie = Movie::updateOrCreate([
            'db_id' => $movieDbId,
        ], [
            'title' => $movieTitle,
            'image_url' => $movieImage,
        ]);

        if (!$movie || !$user) {
            return response()->json([
                'success' => false,
                'message' => 'User or Movie not found!',
            ], 404);
        }

        // Assuming you have a movieWishlist() relationship on User
        $alreadyWishlisted = $user->movieWishlist()->where('movie_id', $movie->id)->exists();

        if ($alreadyWishlisted) {
            $user->movieWishlist()->detach($movie->id);
            $message = 'Movie removed from your wishlist.';
        } else {
            $user->movieWishlist()->attach($movie->id);
            $message = 'Movie added to your wishlist.';
        }

        session()->flash('status', $message);

        return back();
    }

    public function removeMovieWishlist($id)
    {
        $user = Auth::user();
        $movie = Movie::findOrFail($id);

        if ($user->movieWishlist()->where('movie_id', $movie->id)->exists()) {
            $user->movieWishlist()->detach($movie->id);
            session()->flash('status', 'Movie removed from your wishlist.');
        } else {
            session()->flash('status', 'Movie not found in your wishlist.');
        }

        return back();
    }

    public function deleteMovie($id){

        $movie = Movie::findOrFail($id);

        $movie->delete();

        return redirect()->route('category.show',['category'=>'movies'])->with('success', 'Movie deleted successfully!');
    }

public function showList() {

    $watched_movies = Movie::whereHas('users', function($query) {
        $query->where('user_id', Auth::id());
    })->get();

    $wishlisted = Movie::whereHas('wishlist', function($query) {
        $query->where('user_id', Auth::id());
    })->get();

    return view('movies/myMovieList', [
        'watched' => $watched_movies,
        'wishlisted' => $wishlisted
    ]);
}
}
