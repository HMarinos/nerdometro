<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\Anime;
use App\Models\Game;
use Illuminate\Support\Facades\Cache;

class MediaController extends Controller
{

    //anime
    function topAnimeGlobal(){
        return Cache::remember('top_global_anime', 3600, function () {
            $response = Http::get('https://api.jikan.moe/v4/top/anime')->json();
            return $response['data'];
        });
    }

    function topAnimeAiring()
    {
        return Cache::remember('top_airing_anime', 3600, function () {
            $response = Http::get('https://api.jikan.moe/v4/top/anime', [
                'filter' => 'airing',
                'limit' => 12
            ])->json();

            return $response['data'];
        });
    }

    function topAnimeUpcoming()
    {
        return Cache::remember('top_upcoming_anime', 3600, function () {
            $response = Http::get('https://api.jikan.moe/v4/top/anime', [
                'filter' => 'upcoming'
            ])->json();

            return $response['data'];
        });
    }

    function topAnimeFavorites()
    {
        return Cache::remember('top_favorite_anime', 3600, function () {
            $response = Http::get('https://api.jikan.moe/v4/top/anime', [
                'filter' => 'favorite',
                'limit' => 24
            ])->json();

            return $response['data'];
        });
    }

    function topAnimeCharacters()
    {
        return Cache::remember('top_anime_characters', 3600, function () {
            $response = Http::get('https://api.jikan.moe/v4/top/characters', [
                'limit' => 24
            ])->json();

            return $response['data'];
        });
    }

    //movies
    function topMoviesGlobal(){
        return Cache::remember('top_rated_movies', 3600, function () {
            $apiKey = '05abd598284193009c38291a6823dd0c';
            $response = Http::get('https://api.themoviedb.org/3/movie/top_rated', [
                'api_key' => $apiKey
            ])->json();
            return $response['results'];
        });
    }


    function topMoviesAiring(){
        return Cache::remember('top_airing_movies', 3600, function () {
            $apiKey = '05abd598284193009c38291a6823dd0c';
            $response = Http::get('https://api.themoviedb.org/3/movie/now_playing', [
                'api_key' => $apiKey
            ])->json();
            return $response['results'];
        });
    }


    function topMoviesUpcomming(){
        return Cache::remember('top_upcomming_movies', 3600, function () {
            $apiKey = '05abd598284193009c38291a6823dd0c';
            $response = Http::get('https://api.themoviedb.org/3/movie/upcoming', [
                'api_key' => $apiKey
            ])->json();
            return $response['results'];
        });
    }


    function topMoviePeople(){
        return Cache::remember('popular_actors_v4', 3600, function () {
        $bearerToken = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIwNWFiZDU5ODI4NDE5MzAwOWMzODI5MWE2ODIzZGQwYyIsIm5iZiI6MTcwNjU2MDcxOC42MDA5OTk4LCJzdWIiOiI2NWI4MGNjZWY2MjFiMjAxNjNjODFiZTEiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.jd6ERrwpBZRJCmgufB-OXSPCrwO372GGsAGmR3V-CyM';
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken,
            'Content-Type' => 'application/json;charset=utf-8'
        ])->get('https://api.themoviedb.org/3/person/popular');
        
        $data = $response->json();
        
        if (!$response->successful() || !isset($data['results'])) {
            return [];
        }
        
        return $data['results'];
    });
}
    


    //games
    function topGames(){
        return Cache::remember('most_popular_games', 3600, function () {
            $api_key = '925517f17a024b508da64ad9f4d7e388';
            $response = Http::get("https://api.rawg.io/api/games?key={$api_key}&ordering=-added")->json();

            return $response['results'];
        });
    }

    function trendingGames() {
        return Cache::remember('trending_games', 3600, function () {
            $api_key = '925517f17a024b508da64ad9f4d7e388';
            $dates = now()->subDays(30)->format('Y-m-d') . ',' . now()->format('Y-m-d');
            $response = Http::get("https://api.rawg.io/api/games?key={$api_key}&dates={$dates}&ordering=-added")->json();
            return $response['results'];
        });
    }

    function newReleases() {
        return Cache::remember('new_releases', 3600, function () {
            $api_key = '925517f17a024b508da64ad9f4d7e388';
            $start = now()->startOfMonth()->format('Y-m-d');
            $end = now()->endOfMonth()->format('Y-m-d');
            $response = Http::get("https://api.rawg.io/api/games?key={$api_key}&dates={$start},{$end}&ordering=-released")->json();
            return $response['results'];
        });
    }


}