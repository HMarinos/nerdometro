<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;


class UserStatsController extends Controller
{
    public function userStats(){
        $user = auth()->user();

        $watched_animes = $user->anime()->get();
        $total_anime_watched = $watched_animes->count();

        $genreCount = [];

        foreach ($watched_animes as $anime) {
            $genres = $anime->genres ?? [];

            foreach ($genres as $genre) {
                if ($genre) {
                    $genreCount[$genre] = ($genreCount[$genre] ?? 0) + 1;
                }
            }
        }

        $total = array_sum($genreCount);

        $genreStats = [];

        foreach ($genreCount as $genre => $count) {
            $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
            $genreStats[$genre] = $percentage;
        }

        arsort($genreStats);

        $chart = Chartjs::build()
        ->name("AnimeGenresChart")
        ->type("doughnut")
        ->size(["width" => 200, "height" => 200])
            ->labels(array_keys($genreStats))

        ->datasets([
            [
                "label" => "Anime Genres",
                "data" => array_values($genreStats),
                "backgroundColor" => [
                    "rgba(255, 99, 132, 0.7)",
                    "rgba(54, 162, 235, 0.7)",
                    "rgba(255, 206, 86, 0.7)",
                ],
                "borderColor" => "#fff",
                "borderWidth" => 1
            ]
        ]);

        return view('profile/stats', [
            'genreStats' => $genreStats,
            'total_anime_watched' => $total_anime_watched,
            'chart' => $chart
        ]);

    }
}
