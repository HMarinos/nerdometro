<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;

class MovieSearchController extends Controller
{
    //
    public function search(Request $request)
    {
        $query = $request->input('query'); // Consistent with anime method
        $top_results = [];

        if ($query) {
            $apiKey = '05abd598284193009c38291a6823dd0c';
            $url = 'https://api.themoviedb.org/3/search/movie?api_key=' . $apiKey . '&query=' . urlencode($query);
            $response = Http::get($url)->json();

            if (isset($response['results'])) {
                foreach (array_slice($response['results'], 0, 10) as $result) {
                    $top_results[] = [
                        'title' => $result['title'] ?? 'No Title',
                        'image_url' => isset($result['poster_path']) 
                            ? 'https://image.tmdb.org/t/p/w500' . $result['poster_path'] 
                            : null,
                        'db_id' => $result['id'] ?? null
                    ];
                }
            }
        }

        return response()->json($top_results);
    }

    public function searchAll(Request $request)
    {
        $query = $request->input('query');
        $page = $request->input('page', 1);
        $limit = 20;

        $results = [];
        $pagination = null;

        if ($query) {
            
            $apiKey = '05abd598284193009c38291a6823dd0c';
            $url = "https://api.themoviedb.org/3/search/movie?api_key={$apiKey}&query=" . urlencode($query) . "&page={$page}";
            $response = \Illuminate\Support\Facades\Http::get($url)->json();

            if (isset($response['results'])) {
                foreach ($response['results'] as $result) {
                    $results[] = [
                        'title' => $result['title'],
                        'db_id' => $result['id'],
                        'image_url' => isset($result['poster_path']) ? 'https://image.tmdb.org/t/p/w500' . $result['poster_path'] : '',
                    ];
                }

                $pagination = [
                    'current_page' => $response['page'] ?? $page,
                    'last_visible_page' => $response['total_pages'] ?? 1,
                    'has_next_page' => ($response['page'] ?? 1) < ($response['total_pages'] ?? 1),
                ];
            }
        }

        $userWatchedDbIds = [];
        if ($user = \Illuminate\Support\Facades\Auth::user()) {
            $userWatchedDbIds = \DB::table('movie_user')
                ->where('movie_user.user_id', $user->id)
                ->join('movies_list', 'movies_list.id', '=', 'movie_user.movie_id')
                ->pluck('movies_list.db_id')
                ->toArray();
        }

        $userWishlistDbIds = [];
        if ($user = \Illuminate\Support\Facades\Auth::user()) {
            $userWishlistDbIds = \DB::table('movie_user_wishlist')
                ->where('movie_user_wishlist.user_id', $user->id)
                ->join('movies_list', 'movies_list.id', '=', 'movie_user_wishlist.movie_id')
                ->pluck('movies_list.db_id')
                ->toArray();
        }

        return view('movies/searchAllMovies', [
            'results' => $results,
            'query' => $query,
            'pagination' => $pagination,
            'userWishlistIds' => $userWishlistDbIds,
            'userWatchedDbIds' => $userWatchedDbIds,
        ]);
    }

}
