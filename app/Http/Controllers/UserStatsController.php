<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class UserStatsController extends Controller
{
    public function userStats()
    {
        $user = auth()->user();

        // Anime stats
        $watched_animes = $user->anime()->get();
        $total_anime_watched = $watched_animes->count();

        $AnimeGenreCount = [];

        foreach ($watched_animes as $anime) {
            $genres = $anime->genres ?? [];

            if (is_string($genres)) {
                $genres = json_decode($genres, true);
            }

            if (is_array($genres)) {
                foreach ($genres as $genre) {
                    if ($genre) {
                        $AnimeGenreCount[$genre] = ($AnimeGenreCount[$genre] ?? 0) + 1;
                    }
                }
            }
        }

        $anime_total = array_sum($AnimeGenreCount);
        $AnimeGenreStats = [];

        foreach ($AnimeGenreCount as $genre => $count) {
            $percentage = $anime_total > 0 ? round(($count / $anime_total) * 100) : 0;
            $AnimeGenreStats[$genre] = $percentage;
        }

        arsort($AnimeGenreStats);

        // Movie stats
        $watched_movies = $user->movie()->get();
        $total_movies_watched = $watched_movies->count();

        $MovieGenreCount = [];

        foreach ($watched_movies as $movie) {
            $genres = $movie->genres ?? [];

            if (is_string($genres)) {
                $genres = json_decode($genres, true);
            }

            if (is_array($genres)) {
                foreach ($genres as $genre) {
                    if ($genre) {
                        $MovieGenreCount[$genre] = ($MovieGenreCount[$genre] ?? 0) + 1;
                    }
                }
            }
        }

        $movie_total = array_sum($MovieGenreCount);
        $MovieGenreStats = [];

        foreach ($MovieGenreCount as $genre => $count) {
            $percentage = $movie_total > 0 ? round(($count / $movie_total) * 100) : 0;
            $MovieGenreStats[$genre] = $percentage;
        }

        arsort($MovieGenreStats);

        // Color helper
        function generatePastelColors($count)
        {
            $colors = [];
            for ($i = 0; $i < $count; $i++) {
                $r = rand(100, 255);
                $g = rand(100, 255);
                $b = rand(100, 255);
                $colors[] = "rgba($r, $g, $b, 0.7)";
            }
            return $colors;
        }

        // Anime chart
        $chartAnime = Chartjs::build()
            ->name("AnimeGenresChart")
            ->type("doughnut")
            ->size(["width" => 200, "height" => 200])
            ->labels(array_keys($AnimeGenreStats))
            ->datasets([
                [
                    "label" => "Anime Genres",
                    "data" => array_values($AnimeGenreStats),
                    "backgroundColor" => generatePastelColors(count($AnimeGenreStats)),
                    "borderColor" => "#fff",
                    "borderWidth" => 1
                ]
            ]);

        // Movie chart
        $chartMovies = Chartjs::build()
            ->name("MovieGenresChart")
            ->type("doughnut")
            ->size(["width" => 200, "height" => 200])
            ->labels(array_keys($MovieGenreStats))
            ->datasets([
                [
                    "label" => "Movie Genres",
                    "data" => array_values($MovieGenreStats),
                    "backgroundColor" => generatePastelColors(count($MovieGenreStats)),
                    "borderColor" => "#fff",
                    "borderWidth" => 1
                ]
            ]);

            // Game stats
            $played_games = $user->game()->get();
            $total_games_played = $played_games->count();

            $GameGenreCount = [];

            foreach ($played_games as $game) {
                $genres = $game->genres ?? [];

                if (is_string($genres)) {
                    $genres = json_decode($genres, true);
                }

                if (is_array($genres)) {
                    foreach ($genres as $genre) {
                        if ($genre) {
                            $GameGenreCount[$genre] = ($GameGenreCount[$genre] ?? 0) + 1;
                        }
                    }
                }
            }

            $game_total = array_sum($GameGenreCount);
            $GameGenreStats = [];

            foreach ($GameGenreCount as $genre => $count) {
                $percentage = $game_total > 0 ? round(($count / $game_total) * 100) : 0;
                $GameGenreStats[$genre] = $percentage;
            }

            arsort($GameGenreStats);

            // Game chart
            $chartGames = Chartjs::build()
                ->name("GameGenresChart")
                ->type("doughnut")
                ->size(["width" => 200, "height" => 200])
                ->labels(array_keys($GameGenreStats))
                ->datasets([
                    [
                        "label" => "Game Genres",
                        "data" => array_values($GameGenreStats),
                        "backgroundColor" => generatePastelColors(count($GameGenreStats)),
                        "borderColor" => "#fff",
                        "borderWidth" => 1
                    ]
                ]);

        return view('profile/stats', [
            'AnimeGenreStats' => $AnimeGenreStats,
            'total_anime_watched' => $total_anime_watched,
            'chartAnime' => $chartAnime,

            'MovieGenreStats' => $MovieGenreStats,
            'total_movies_watched' => $total_movies_watched,
            'chartMovies' => $chartMovies,

            'GameGenreStats' => $GameGenreStats,
            'total_games_played' => $total_games_played,
            'chartGames' => $chartGames,
        ]);
    }
}
