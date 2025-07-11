<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;



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
        $limit = 20;

        $results = [];
        $pagination = null;

        if ($query) {
            $apiKey = '925517f17a024b508da64ad9f4d7e388';
            $url = "https://api.rawg.io/api/games?key={$apiKey}&search=" . urlencode($query) . "&page={$page}&page_size={$limit}";
            $response = Http::get($url)->json();

            if (isset($response['results'])) {
                foreach ($response['results'] as $game) {
                    $results[] = [
                        'title' => $game['name'],
                        'db_id' => $game['id'],
                        'image_url' => $game['background_image'] ?? null,
                    ];
                }

                if (isset($response['count'])) {
                    $totalResults = $response['count'];
                    $lastPage = (int) ceil($totalResults / $limit);

                    $pagination = [
                        'total' => $totalResults,
                        'page' => (int) $page,
                        'current_page' => (int) $page,
                        'last_visible_page' => $lastPage,
                        'has_next_page' => isset($response['next']),
                        'has_prev_page' => isset($response['previous']),
                    ];
                }
            }
        }

        $user = Auth::user();

        $userPlayedDbIds = [];
        if ($user) {
            $userPlayedDbIds = \DB::table('game_user')
                ->where('game_user.user_id', $user->id)
                ->join('games_list', 'games_list.id', '=', 'game_user.game_id')
                ->pluck('games_list.db_id')
                ->toArray();
        }

        $userWishlistDbIds = [];
        if ($user) {
            $userWishlistDbIds = \DB::table('game_user_wishlist')
                ->where('game_user_wishlist.user_id', $user->id)
                ->join('games_list', 'games_list.id', '=', 'game_user_wishlist.game_id')
                ->pluck('games_list.db_id')
                ->toArray();
        }

        return view('games/searchAllGames', [
            'results' => $results,
            'query' => $query,
            'pagination' => $pagination,
            'userWishlistIds' => $userWishlistDbIds,
            'userPlayedDbIds' => $userPlayedDbIds,
        ]);
    }



}
