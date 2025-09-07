<x-app-layout class="!p-0">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("tabsApp", () => ({
                // Use session('active_tab') if available, otherwise default to 'anime'
                activeTab: "{{ session('active_tab', 'anime') }}",
                tabs: [
                    { id: 'anime', name: 'Anime' },
                    { id: 'movies', name: 'Movies' },
                    { id: 'games', name: 'Games' },
                ],
                setTab(id) {
                    this.activeTab = id;
                },
            }));
        });
    </script>

    <div class="min-h-screen" x-data="tabsApp">
        <div class="container mx-auto px-4 py-8 max-w-[1600px]">
            <!-- Header -->
            <div class="text-center mb-8">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-200 mb-2">My Lists</h1>
            <p class="text-sm sm:text-md text-gray-400">Organize your entertainment library</p>
            </div>
        
            <!-- Tab Navigation -->
            <div class="bg-white rounded-2xl shadow-sm p-2 mb-8 max-w-[768px] mx-auto">
                <div class="flex space-x-1">
                    <template x-for="tab in tabs" :key="tab.id">
                        <button
                            @click="setTab(tab.id)"
                            class="flex items-center space-x-2 px-6 py-3 rounded-xl font-medium transition-all duration-200 flex-1 justify-center"
                            :class="activeTab === tab.id
                                ? {
                                    'text-white shadow-lg transform scale-[1.02]': true,
                                    'bg-animecolor shadow-red-500/25': tab.name === 'Anime',
                                    'bg-gamecolor shadow-yellow-500/25': tab.name === 'Games',
                                    'bg-moviecolor shadow-blue-500/25': tab.name === 'Movies'
                                }
                                : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50'">
                            <span x-text="tab.name"></span>
                        </button>
                    </template>

                </div>

            </div>
        
            <!-- Tab Content -->
            <div class="transition-all duration-300 ease-in-out">
            <!-- Anime -->
            <template x-if="activeTab === 'anime'">
                <div class="space-y-8">
                    <!-- My Completed -->
                    <div class="bg-transparent rounded-xl shadow-sm p-1">
                        <h3 class="text-xl font-semibold text-gray-200 mb-4 flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                        My Completed
                        </h3>
                        <div class="bg-[rgba(255,255,255,0.05)] rounded-lg p-4 text-center tabcontent anime">
                            @if(isset($watched_anime) && count($watched_anime) > 0)
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 cont">
                                    @foreach ($watched_anime as $anime)
                                        <div>
                                            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-1 md:gap-4 px-2 mb-2">
                                                <div class="flex items-center gap-1 text-yellow-400 opacity-60">
                                                    <i class="fa-xs fa-solid fa-star "></i>
                                                    <div class="text-xs font-bold">{{$anime->rating ?? 'N/A'}}</div>
                                                </div>
                                                <div>
                                                    @php
                                                    $ratingLabels = [
                                                        0    => '0',
                                                        0.5  => '0.5',
                                                        1    => '1',
                                                        1.5  => '1.5',
                                                        2    => '2',
                                                        2.5  => '2.5',
                                                        3    => '3',
                                                        3.5  => '3.5',
                                                        4    => '4',
                                                        4.5  => '4.5',
                                                        5    => '5',
                                                        5.5  => '5.5',
                                                        6    => '6',
                                                        6.5  => '6.5',
                                                        7    => '7',
                                                        7.5  => '7.5',
                                                        8    => '8',
                                                        8.5  => '8.5',
                                                        9    => '9',
                                                        9.5  => '9.5',
                                                        10   => '10',
                                                    ];
                                                    @endphp
                                                    <div class="flex gap-1 items-center">
                                                        <span class="text-gray-200 text-xs">My rating</span>
                                                        <form action="{{ route('anime.updateRating', $anime->id) }}" method="POST" class="m-0">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="active_tab" value="anime">
                                                            <select name="user_rating"
                                                                class="rounded-md border border-gray-600 bg-gray-800 text-gray-200 py-1 text-xs focus:border-purple-500 focus:ring-purple-500 cursor-pointer max-w-[85px]"
                                                                onchange="this.form.submit()">
                                                                <option value="">N/A</option>
                                                                @foreach ($ratingLabels as $value => $label)
                                                                    <option value="{{ $value }}" {{ $anime->pivot->user_rating === $value ? 'selected' : '' }}>
                                                                        {{ $label }}⭐
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <li class="rounded-lg item border relative cursor-pointer flex flex-col justify-between items-center group overflow-hidden">
                                                <img src="{{$anime['image_url']}}" alt="anime image" class="w-full h-auto rounded-[4px_4px_0_0] transition-all">
                                                <div class="title decoration-[rebeccapurple] group-hover:underline">
                                                    <a href="/anime/{{$anime['db_id']}}">{{$anime['title']}}</a>
                                                </div>
                                                <form action="{{route('anime.delete',$anime->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="active_tab" value="anime">
                                                    <button type="submit" class="w-[30px] h-[30px] absolute top-[10px] left-[10px] rounded-full flex justify-center items-center border border-red-600 bg-red-600 z-[10] opacity-0 group-hover:opacity-100 transition-all"><i class="fa-solid fa-xmark"></i></button>
                                                </form>
                                            </li>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No completed anime yet</p>
                                <a href="/category/anime" class="text-sm text-gray-400 mt-1 underline">Add your finished anime here</a>
                            @endif
                        </div>
                    </div>
                    <!-- For Future Me -->
                    <div class="bg-transparent rounded-xl shadow-sm p-1">
                        <h3 class="text-xl font-semibold text-gray-200 mb-4 flex items-center">
                        <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3"></div>
                        For Future Me
                        </h3>
                        <div class="bg-[rgba(255,255,255,0.05)] rounded-lg p-4 text-center tabcontent anime">
                            @if(isset($wishlisted_anime) && count($wishlisted_anime) > 0)
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 cont">
                                    @foreach ($wishlisted_anime as $anime_wish)
                                        <li class="rounded-lg item border relative cursor-pointer flex flex-col justify-between items-center group overflow-hidden">
                                            <img src="{{$anime_wish['image_url']}}" alt="anime image" class="w-full h-auto rounded-[4px_4px_0_0] transition-all">
                                            <div class="title decoration-[rebeccapurple] group-hover:underline">
                                                <a href="/anime/{{$anime_wish['db_id']}}">{{$anime_wish['title']}}</a>
                                            </div>

                                            <form action="{{route('anime.remove.wishlist',$anime_wish->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="active_tab" value="anime">
                                                <button type="submit" class="w-[30px] h-[30px] absolute top-[10px] left-[10px] rounded-full flex justify-center items-center border border-red-600 bg-red-600 z-[10] opacity-0 group-hover:opacity-100 transition-all"><i class="fa-solid fa-xmark"></i></button>
                                            </form>
                                        </li>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No anime in your watchlist</p>
                                <a href="/category/anime" class="text-sm text-gray-400 mt-1 underline">Add anime you want to watch later</a>
                            @endif
                        </div>
                    </div>
                </div>
            </template>
        
            <!-- Movies -->
            <template x-if="activeTab === 'movies'">
                <div class="space-y-8">
                    <!-- My Completed -->
                    <div class="bg-transparent rounded-xl shadow-sm p-1">
                        <h3 class="text-xl font-semibold text-gray-200 mb-4 flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                        My Completed
                        </h3>
                        <div class="bg-[rgba(255,255,255,0.05)] rounded-lg p-4 text-center tabcontent anime">
                            @if(isset($watched_movies) && count($watched_movies) > 0)
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 cont">
                                    @foreach ($watched_movies as $movie)
                                        <div>
                                            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-1 md:gap-4 px-2 mb-2">
                                                <div class="flex items-center gap-1 text-yellow-400 opacity-60">
                                                    <i class="fa-xs fa-solid fa-star "></i>
                                                    <div class="text-xs font-bold">{{$movie->rating ?? 'N/A'}}</div>
                                                </div>
                                                <div>
                                                    @php
                                                    $ratingLabels = [
                                                        0    => '0',
                                                        0.5  => '0.5',
                                                        1    => '1',
                                                        1.5  => '1.5',
                                                        2    => '2',
                                                        2.5  => '2.5',
                                                        3    => '3',
                                                        3.5  => '3.5',
                                                        4    => '4',
                                                        4.5  => '4.5',
                                                        5    => '5',
                                                        5.5  => '5.5',
                                                        6    => '6',
                                                        6.5  => '6.5',
                                                        7    => '7',
                                                        7.5  => '7.5',
                                                        8    => '8',
                                                        8.5  => '8.5',
                                                        9    => '9',
                                                        9.5  => '9.5',
                                                        10   => '10',
                                                    ];
                                                    @endphp
                                                    <div class="flex gap-1 items-center">
                                                        <span class="text-gray-200 text-xs">My rating</span>
                                                        <form action="{{ route('movie.updateRating', $movie->id) }}" method="POST" class="m-0">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="active_tab" value="movies">
                                                            <select name="user_rating"
                                                                class="rounded-md border border-gray-600 bg-gray-800 text-gray-200 py-1 text-xs focus:border-purple-500 focus:ring-purple-500 cursor-pointer max-w-[85px]"
                                                                onchange="this.form.submit()">
                                                                <option value="">N/A</option>
                                                                @foreach ($ratingLabels as $value => $label)
                                                                    <option value="{{ $value }}" {{ $movie->pivot->user_rating === $value ? 'selected' : '' }}>
                                                                        {{ $label }}⭐
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <li class="rounded-lg item border relative cursor-pointer flex flex-col justify-between items-center group overflow-hidden">
                                                <img src="{{$movie['image_url']}}" alt="movie image" class="w-full h-auto rounded-[4px_4px_0_0] transition-all">
                                                <div class="title decoration-[rebeccapurple] group-hover:underline">
                                                    <a href="/movie/{{$movie['db_id']}}">{{$movie['title']}}</a>
                                                </div>
                                                <form action="{{route('movie.delete',$movie->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="active_tab" value="movies">
                                                    <button type="submit" class="w-[30px] h-[30px] absolute top-[10px] left-[10px] rounded-full flex justify-center items-center border border-red-600 bg-red-600 z-[10] opacity-0 group-hover:opacity-100 transition-all"><i class="fa-solid fa-xmark"></i></button>
                                                </form>
                                            </li>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No completed movies yet</p>
                                <a href="/category/movies" class="text-sm text-gray-400 mt-1 underline">Add your finished movies here</a>
                            @endif
                        </div>
                    </div>
                    <!-- For Future Me -->
                    <div class="bg-transparent rounded-xl shadow-sm p-1">
                        <h3 class="text-xl font-semibold text-gray-200 mb-4 flex items-center">
                        <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3"></div>
                        For Future Me
                        </h3>
                        <div class="bg-[rgba(255,255,255,0.05)] rounded-lg p-4 text-center tabcontent anime">
                            @if(isset($wishlisted_movies) && count($wishlisted_movies) > 0)
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 cont">
                                    @foreach ($wishlisted_movies as $movie_wish)
                                        <li class="rounded-lg item border relative cursor-pointer flex flex-col justify-between items-center group overflow-hidden">
                                            <img src="{{$movie_wish['image_url']}}" alt="anime image" class="w-full h-auto rounded-[4px_4px_0_0] transition-all">
                                            <div class="title decoration-[rebeccapurple] group-hover:underline">
                                                <a href="/anime/{{$movie_wish['db_id']}}">{{$movie_wish['title']}}</a>
                                            </div>

                                            <form action="{{route('movie.remove.wishlist',$movie_wish->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="active_tab" value="movies">
                                                <button type="submit" class="w-[30px] h-[30px] absolute top-[10px] left-[10px] rounded-full flex justify-center items-center border border-red-600 bg-red-600 z-[10] opacity-0 group-hover:opacity-100 transition-all"><i class="fa-solid fa-xmark"></i></button>
                                            </form>
                                        </li>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No movies in your watchlist</p>
                                <a href="/category/movies" class="text-sm text-gray-400 mt-1 underline">Add movies you want to watch later</a>
                            @endif
                        </div>
                    </div>
                </div>
            </template>
        
            <!-- Games -->
            <template x-if="activeTab === 'games'">
                <div class="space-y-8">
                    {{-- My Completed --}}
                    <div class="bg-transparent rounded-xl shadow-sm p-1">
                        <h3 class="text-xl font-semibold text-gray-200 mb-4 flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                        My Completed
                        </h3>
                        <div class="bg-[rgba(255,255,255,0.05)] rounded-lg p-4 text-center tabcontent anime">
                            @if(isset($played_games) && count($played_games) > 0)
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 cont">
                                    @foreach ($played_games as $game)
                                        <div>
                                            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-1 md:gap-4 px-2 mb-2">
                                                <div class="flex items-center gap-1 text-yellow-400 opacity-60">
                                                    <i class="fa-xs fa-solid fa-star "></i>
                                                    <div class="text-xs font-bold">{{$game->rating ?? 'N/A'}}</div>
                                                </div>
                                                <div>
                                                    @php
                                                    $ratingLabels = [
                                                        0    => '0',
                                                        0.5  => '0.5',
                                                        1    => '1',
                                                        1.5  => '1.5',
                                                        2    => '2',
                                                        2.5  => '2.5',
                                                        3    => '3',
                                                        3.5  => '3.5',
                                                        4    => '4',
                                                        4.5  => '4.5',
                                                        5    => '5',
                                                        5.5  => '5.5',
                                                        6    => '6',
                                                        6.5  => '6.5',
                                                        7    => '7',
                                                        7.5  => '7.5',
                                                        8    => '8',
                                                        8.5  => '8.5',
                                                        9    => '9',
                                                        9.5  => '9.5',
                                                        10   => '10',
                                                    ];
                                                    @endphp
                                                    <div class="flex gap-1 items-center">
                                                        <span class="text-gray-200 text-xs">My rating</span>
                                                        <form action="{{ route('game.updateRating', $game->id) }}" method="POST" class="m-0">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="active_tab" value="games">
                                                            <select name="user_rating"
                                                                class="rounded-md border border-gray-600 bg-gray-800 text-gray-200 py-1 text-xs focus:border-purple-500 focus:ring-purple-500 cursor-pointer max-w-[85px]"
                                                                onchange="this.form.submit()">
                                                                <option value="">N/A</option>
                                                                @foreach ($ratingLabels as $value => $label)
                                                                    <option value="{{ $value }}" {{ $game->pivot->user_rating === $value ? 'selected' : '' }}>
                                                                        {{ $label }}⭐
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <li class="rounded-lg item border relative cursor-pointer flex flex-col justify-between items-center group overflow-hidden">
                                                <img src="{{$game['image_url']}}" alt="game image" class="w-full h-auto rounded-[4px_4px_0_0] transition-all">
                                                <div class="title decoration-[rebeccapurple] group-hover:underline">
                                                    <a href="/game/{{$game['db_id']}}">{{$game['title']}}</a>
                                                </div>
                                                <form action="{{route('game.delete',$game->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="active_tab" value="games">
                                                    <button type="submit" class="w-[30px] h-[30px] absolute top-[10px] left-[10px] rounded-full flex justify-center items-center border border-red-600 bg-red-600 z-[10] opacity-0 group-hover:opacity-100 transition-all"><i class="fa-solid fa-xmark"></i></button>
                                                </form>
                                            </li>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No games played yet</p>
                                <a href="/category/games" class="text-sm text-gray-400 mt-1 underline">Add the games you've a layed here</a>
                            @endif
                        </div>
                    </div>
                    {{-- For Future Me --}}
                    <div class="bg-transparent rounded-xl shadow-sm p-1">
                        <h3 class="text-xl font-semibold text-gray-200 mb-4 flex items-center">
                        <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3"></div>
                        For Future Me
                        </h3>
                        <div class="bg-[rgba(255,255,255,0.05)] rounded-lg p-4 text-center tabcontent anime">
                            @if(isset($wishlisted_games) && count($wishlisted_games) > 0)
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 cont">
                                    @foreach ($wishlisted_games as $game_wish)
                                        <li class="rounded-lg item border relative cursor-pointer flex flex-col justify-between items-center group overflow-hidden">
                                            <img src="{{$game_wish['image_url']}}" alt="anime image" class="w-full h-auto rounded-[4px_4px_0_0] transition-all">
                                            <div class="title decoration-[rebeccapurple] group-hover:underline">
                                                <a href="/anime/{{$game_wish['db_id']}}">{{$game_wish['title']}}</a>
                                            </div>

                                            <form action="{{route('game.remove.wishlist',$game_wish->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="active_tab" value="games">
                                                <button type="submit" class="w-[30px] h-[30px] absolute top-[10px] left-[10px] rounded-full flex justify-center items-center border border-red-600 bg-red-600 z-[10] opacity-0 group-hover:opacity-100 transition-all"><i class="fa-solid fa-xmark"></i></button>
                                            </form>
                                        </li>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No games in your watchlist</p>
                                <a href="/category/games" class="text-sm text-gray-400 mt-1 underline">Add games you want to play later</a>
                            @endif
                        </div>
                    </div>
                </div>
            </template>
            </div>
        
            <!-- Footer -->
            <div class="text-center mt-12 text-gray-400 text-sm">
            <p>Keep track of your favorite entertainment</p>
            </div>
        </div>
    </div>

</x-app-layout>
