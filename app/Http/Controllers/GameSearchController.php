<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Game;

class GameSearchController extends Controller
{
    //
    public function search(Request $request)
    {
        $query = $request->input('query');
        $top_results = [];

        if ($query) {
            $api_key = '925517f17a024b508da64ad9f4d7e388';
            $url = 'https://api.rawg.io/api/games?key=' . $api_key . '&search=' . urlencode($query);
            $response = Http::get($url)->json();

            if (isset($response['results'])) {
                foreach (array_slice($response['results'], 0, 10) as $result) {
                    $top_results[] = [
                        'title' => $result['name'] ?? 'No Title',
                        'image_url' => $result['background_image'] ?? null,
                        'db_id' => $result['id'] ?? null,
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
        $page_size = 20;

        $results = [];
        $pagination = null;

        if ($query) {
            $api_key = '925517f17a024b508da64ad9f4d7e388';
            $url = "https://api.rawg.io/api/games?key={$api_key}&search=" . urlencode($query) . "&page={$page}&page_size={$page_size}";
            $response = Http::get($url)->json();

            if (isset($response['results'])) {
                foreach ($response['results'] as $result) {
                    $results[] = [
                        'title' => $result['name'] ?? 'No Title',
                        'db_id' => $result['id'] ?? null,
                        'image_url' => $result['background_image'] ?? null,
                    ];
                }

                // RAWG gives next/previous, not traditional pagination
                if (isset($response['count'])) {
                    $pagination = [
                        'total' => $response['count'],
                        'page' => $page,
                        'per_page' => $page_size,
                        'has_next' => isset($response['next']),
                        'has_prev' => isset($response['previous']),
                    ];
                }
            }
        }

        // Eloquent-based approach to get watched and wishlist IDs
        $userWatchedDbIds = [];
        $userWishlistDbIds = [];

        if ($user = auth()->user()) {
            $userWatchedDbIds = $user->watchedGames()->pluck('db_id')->toArray();
            $userWishlistDbIds = $user->wishlistGames()->pluck('db_id')->toArray();
        }

        return view('games.searchAllGames', [
            'results' => $results,
            'query' => $query,
            'pagination' => $pagination,
            'userWatchedDbIds' => $userWatchedDbIds,
            'userWishlistDbIds' => $userWishlistDbIds,
        ]);
    }


}
