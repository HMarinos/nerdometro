<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;


class UserStatsController extends Controller
{
    public function userStats(){
        $user = auth()->user();

        //anime stats
        $watched_animes = $user->anime()->get();
        $total_anime_watched = $watched_animes->count();


        $AnimeGenreCount = [];

        foreach ($watched_animes as $anime) {
            $anime_genres = $anime->genres ?? [];

            // dd($anime->genres, gettype($anime->genres));

            $AnimeGenreCount = [];

            foreach ($user->anime as $anime) {
                $genres = $anime->genres ?? [];

                if (is_array($genres)) {
                    foreach ($genres as $genre) {
                        if ($genre) {
                            $AnimeGenreCount[$genre] = ($AnimeGenreCount[$genre] ?? 0) + 1;
                        }
                    }
                }
            }

        }

        $total = array_sum($AnimeGenreCount);

        $AnimeGenreStats = [];

        foreach ($AnimeGenreCount as $genre => $count) {
            $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
            $AnimeGenreStats[$genre] = $percentage;
        }

        arsort($AnimeGenreStats);

        $chartAnime = Chartjs::build()
        ->name("AnimeGenresChart")
        ->type("doughnut")
        ->size(["width" => 200, "height" => 200])
            ->labels(array_keys($AnimeGenreStats))

        ->datasets([
            [
                "label" => "Anime Genres",
                "data" => array_values($AnimeGenreStats),
                "backgroundColor" => [
                    "rgba(255, 99, 132, 0.7)",
                    "rgba(54, 162, 235, 0.7)",
                    "rgba(255, 206, 86, 0.7)",
                ],
                "borderColor" => "#fff",
                "borderWidth" => 1
            ]
        ]);

        dd($chartAnime);

        

        return view('profile/stats', [
            'AnimeGenreStats' => $AnimeGenreStats,
            'total_anime_watched' => $total_anime_watched,
            'chartAnime' => $chartAnime
        ]);

    }
}
