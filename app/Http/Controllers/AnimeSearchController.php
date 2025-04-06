<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Anime;

class AnimeSearchController extends Controller
{
    //
    public function search(Request $request)
    {
        $query = $request->input('query'); // Capture search input
        $top_results = [];

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

}
