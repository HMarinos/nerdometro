<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section class="p-6 text-white">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">

            <!-- Anime Stats -->
            <div class="bg-[#1a1a2e] rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-4 text-rebeccapurple">Anime Stats</h2>
                <div class="grid grid-cols-3 gap-4 mb-8 border-b-4 pb-8 border-[#121212]">
                    <div>
                        <p class="text-purple-300">Total Anime Watched</p>
                        <p class="text-2xl font-bold">{{ $total_anime_watched }}</p>
                    </div>
                    <div>
                        <p class="text-purple-300">Total Episodes Watched</p>
                        <p class="text-2xl font-bold">{{ $total_episodes_watched_anime }}</p>
                    </div>
                    <div>
                        <p class="text-purple-300">Total Watch Time</p>
                        <p class="text-2xl font-bold">{{ $anime_hours_watched }} <span class="text-sm">h</span></p>
                    </div>
                </div>
                <div class="mt-8 max-w-[500px] mx-auto">
                    <p class="text-purple-300 text-center mt-8 mb-4">Genres Distribution (%)</p>
                    <x-chartjs-component :chart="$chartAnime" />
                </div>
            </div>

            <!-- Movie Stats -->
            <div class="bg-[#1a1a2e] rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-4 text-rebeccapurple">Movie Stats</h2>
                <div class="grid grid-cols-3 gap-4 mb-8 border-b-4 pb-8 border-[#121212]">
                    <div>
                        <p class="text-purple-300">Total Movies Watched</p>
                        <p class="text-2xl font-bold">{{ $total_movies_watched }}</p>
                    </div>
                    <div>
                        <p class="text-purple-300">Total Watch Time</p>
                        <p class="text-2xl font-bold">{{ $movies_hours_watched }} <span class="text-sm">h</span></p>
                    </div>
                </div>
                <div class="mt-8 max-w-[500px] mx-auto">
                    <p class="text-purple-300 text-center mt-8 mb-4">Genres Distribution (%)</p>
                    <x-chartjs-component :chart="$chartMovies" />
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
            
            <!-- Game Stats -->
            <div class="bg-[#1a1a2e] rounded-lg shadow-lg p-6 col-span-1">
                <h2 class="text-2xl font-bold mb-4 text-rebeccapurple">Game Stats</h2>
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div>
                        <p class="text-purple-300">Total Games Played</p>
                        <p class="text-2xl font-bold">{{ $total_games_played }}</p>
                    </div>
                    {{-- <div>
                        <p class="text-purple-300">Total Time Spent</p>
                        <p class="text-2xl font-bold">-</p>
                    </div> --}}
                </div>
                {{-- <div class="mt-8">
                    <x-chartjs-component :chart="$chartGames" />
                </div> --}}
            </div>

            <!-- Fun Facts -->
            <div class="bg-[#1a1a2e] rounded-lg shadow-lg p-6 md:col-span-2 lg:col-span-2">
                <h2 class="text-2xl font-bold mb-4 text-rebeccapurple">Fun Facts</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-purple-300">Fan Favorite You Haven't Touched</p>
                        <p class="text-2xl font-bold">-</p>
                    </div>
                    <div>
                        <p class="text-purple-300">Nostalgia Trip (Classics vs. New)</p>
                        <p class="text-2xl font-bold">-</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>