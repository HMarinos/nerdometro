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

}
