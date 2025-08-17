<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;


class MovieController extends Controller
{

    public function category(Request $request){

        $mediaController = new MediaController();
        $movies_global = $mediaController-> topMoviesGlobal();
        $movies_airing = $mediaController-> topMoviesAiring();
        $movies_people = $mediaController-> topMoviePeople();
        $test = $mediaController-> popularActorsV4();
        dump($test);

        // dump($anime_characters);

        return view('/movies/category',[
            'movies_global' => $movies_global,
            'movies_airing' => $movies_airing,
            'movies_people' => $movies_people 
        ]);

    }


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
            'data_id'    => 'required',
            'data_genres' => 'nullable|string',
            'data_duration' => 'nullable|integer'
        ]);

        $movieTitle = $validateData['data_title'];
        $movieImage = $validateData['data_image'];
        $movieId = $validateData['data_id'];
        $movieDuration = $validateData['data_duration'];

        $rawGenres = json_decode($validateData['data_genres'] ?? '[]', true);

        $genreNames = collect($rawGenres)
            ->map(function ($item) {
                if (is_array($item) && array_key_exists('name', $item)) {
                    return $item['name'];
                }
                if (is_object($item) && property_exists($item, 'name')) {
                    return $item->name;
                }
                return $item;
            })
            ->filter()
            ->unique()
            ->values()
            ->all();

        $genresJson = json_encode($genreNames); 

        $user = Auth::user();

        $movie = Movie::updateOrCreate(
            ['db_id' => $movieId],
            [
                'title'     => $movieTitle,
                'image_url' => $movieImage,
                'genres'    => $genresJson, 
                'duration'  => $movieDuration
            ]
        );

        if (!$movie || !$user) {
            return response()->json([
                'success' => false,
                'message' => 'User or Movie not found!',
            ], 404);
        }

        $alreadyAdded = $user->movie()->where('movie_id', $movie->id)->exists();

        if ($alreadyAdded) {
            $user->movie()->detach($movie->id);
            $message = 'Movie removed from your watched list.';
        } else {
            $user->movie()->attach($movie->id);
            $message = 'Movie added to your watched list.';
        }

        session()->flash('status', $message);
        return back();
        
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
        $user = Auth::user();

        $user->movie()->detach($movie->id);

        return redirect()->back()->with('success', 'Movie deleted successfully!');

    }

    // public function showList() {

    //     $watched_movies = Movie::whereHas('users', function($query) {
    //         $query->where('user_id', Auth::id());
    //     })->get();

    //     $wishlisted = Movie::whereHas('wishlist', function($query) {
    //         $query->where('user_id', Auth::id());
    //     })->get();

    //     return view('movies/myMovieList', [
    //         'watched' => $watched_movies,
    //         'wishlisted' => $wishlisted
    //     ]);
    // }
}
