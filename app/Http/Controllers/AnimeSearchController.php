<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Anime;
use Illuminate\Support\Facades\Auth;

class AnimeSearchController extends Controller
{
    //
    public function search(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $url = 'https://api.jikan.moe/v4/anime?q=' . $query;
            $response = Http::get($url)->json();

            if (isset($response['data'])) {
                foreach (array_slice($response['data'], 0, 10) as $result) {
                    $top_results[] = [
                        'title' => $result['title'],
                        'image_url' => $result['images']['webp']['image_url'],
                        'db_id' => $result['mal_id']
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
            $url = 'https://api.jikan.moe/v4/anime?q=' . urlencode($query) . "&page={$page}&limit={$limit}";
            $response = Http::get($url)->json();
    
            if (isset($response['data'])) {
                foreach ($response['data'] as $result) {
                    $results[] = [
                        'title' => $result['title'],
                        'mal_id' => $result['mal_id'],  
                        'image_url' => $result['images']['jpg']['image_url'],  
                        'genres' => $result['genres'] ?? [],
                        'episodes' => $result['episodes'] ?? null,
                        'duration' => $result['duration'] ?? null,
                    ];
                }
    
                if (isset($response['pagination'])) {
                    $pagination = $response['pagination'];
                }
            }
        }

        $userWatchedDbIds = [];

        if ($user = Auth::user()) {
            $userWatchedDbIds = \DB::table('anime_user') 
                ->where('anime_user.user_id', $user->id)
                ->join('anime_list', 'anime_list.id', '=', 'anime_user.anime_id')
                ->pluck('anime_list.db_id')
                ->toArray();
        }

        $userWishlistDbIds = [];
        if ($user = Auth::user()) {
            $userWishlistDbIds = \DB::table('anime_user_wishlist')
            ->where('anime_user_wishlist.user_id', $user->id)
            ->join('anime_list', 'anime_list.id', '=', 'anime_user_wishlist.anime_id')
            ->pluck('anime_list.db_id')
            ->toArray();
        }        

        return view('anime/searchAllAnime', [
            'results' => $results,
            'query' => $query,
            'pagination' => $pagination,
            'userWishlistIds' => $userWishlistDbIds,
            'userWatchedDbIds' => $userWatchedDbIds,
        ]);
    }

}
