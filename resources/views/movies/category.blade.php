<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section>
        <h1 class="text-center mb-12 text-moviecolor  uppercase font-bold">Movies</h1>
        <div class="relative">
            <form class="text-center max-w-[768px] mx-auto flex items-center" method="GET" action="#" id="game-search-form">
                <input id="movie-search-input" class="text-moviecolor shadow-moviecolor shadow-md bg-white rounded-[100px] h-[45px] pr-[50px] w-full" type="text" placeholder="search.." name="search" value="{{request('search')}}">
                <button class="-ml-[50px] h-[45px] bg-[rgba(0,0,0,0.1)] w-[45px] rounded-full scale-[0.8] group hover:bg-moviecolor transition-all"><i class="fa-solid fa-magnifying-glass text-moviecolor group-hover:text-white transition-all"></i></button>
            </form>
            @csrf
            <div id="results" class="max-w-[768px] mx-auto flex flex-col gap-2 max-h-[450px] overflow-auto mt-4 absolute top-[50px] left-[50%] translate-x-[-50%] bg-[rgba(0,0,0,0.8)] px-4 z-[10] backdrop-blur-[10px] shadow-[0 0 20px white]">
            </div>
        </div>
    </section>

    <section class="mb-12 mt-8 bg-[rgba(255,255,255,0.05)] rounded-lg p-4">
        <h2 class="flex items-center justify-start mb-2"><span class="w-[8px] h-[8px] bg-moviecolor rounded-full mr-2"></span><span>Best of all time</span></h2>
        <div class="tabcontent movie">
            <div class="swiper movieswiper1">
                <div class="swiper-wrapper">
                    @foreach ($movies_global as $global)
                        <div class="swiper-slide cont">
                            <div class="rounded-lg item flex flex-col justify-between items-center group overflow-hidden">
                                <a href="/movie/{{ $global['id'] }}">
                                    <img class="w-full h-auto rounded-[4px_4px_0_0] transition-all" src="https://image.tmdb.org/t/p/w500{{ $global['poster_path'] }}" alt="">
                                    <div class="title">
                                        <span class="z-20">{{ $global['title'] ?? '-'}}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <section class="mb-12 mt-8 bg-[rgba(255,255,255,0.1)] rounded-lg p-4">
        <h2 class="flex items-center justify-start mb-2"><span class="w-[8px] h-[8px] bg-moviecolor rounded-full mr-2"></span>Top airing</h2>
        <div class="tabcontent movie">
            <div class="swiper movieswiper2">
                <div class="swiper-wrapper">
                    @foreach ($movies_airing as $airing)
                        <div class="swiper-slide cont">
                            <div class="rounded-lg item flex flex-col justify-between items-center group overflow-hidden">
                                <a href="/movie/{{ $airing['id'] }}">
                                    <img class="w-full h-auto rounded-[4px_4px_0_0] transition-all" src="https://image.tmdb.org/t/p/w500{{ $airing['poster_path'] }}" alt="">
                                    <div class="title">
                                        <span class="z-20">{{ $airing['title'] ?? '-'}}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <section class="mb-12 mt-8 bg-[rgba(255,255,255,0.1)] rounded-lg p-4">
        <h2 class="flex items-center justify-start mb-2">
            <span class="w-[8px] h-[8px] bg-moviecolor rounded-full mr-2"></span>People
        </h2>
        <div class="tabcontent movie grid grid-cols-4 gap-10">
            @foreach ($actors as $actor)
                <div class="relative group hover:z-20">
                    <div class="flex pr-4 pb-4 gap-2 flex-col">
                        <div class="relative">
                            <div>
                                <img class="rounded-md w-full h-auto" src="https://image.tmdb.org/t/p/w500{{ $actor['profile_path'] }}" alt="">
                            </div>
                            <div class="absolute inset-0 p-4 pt-12 flex flex-col items-center bg-[rgba(0,0,0,0.8)] transition-all opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto group-hover:z-10">
                                <div class="text-center mb-4 text-white">Known for</div>
                                <div class="flex flex-wrap items-center justify-start gap-2">
                                    @if(isset($actor['known_for']))
                                        @foreach($actor['known_for'] as $known)
                                            <a href="/movie/{{ $known['id'] }}" class="cursor-pointer group/known">
                                                <img class="rounded-md max-w-[80px] transition-transform group-hover/known:scale-90" src="https://image.tmdb.org/t/p/w200{{ $known['poster_path'] }}" alt="">
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-sm mx-auto text-center mt-2 text-white">
                            {{ $actor['name'] ?? '-'}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-app-layout>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  

<script>
    $(document).ready(function () {
        let debounceTimer;

        $('#movie-search-input').on('keyup', function () {
            clearTimeout(debounceTimer);

            let query = $(this).val();

            debounceTimer = setTimeout(() => {
                if (query.length < 3) {
                    $('#results').html('');
                    return;
                }

                let searchUrl = `/search/movies?query=${query}`;

                $.ajax({
                    url: searchUrl,
                    type: "GET",
                    success: function (data) {
                        let results = '';
                        if (data.length > 0) {
                            data.forEach(item => {
                                if (item.db_id) {
                                    results += `
                                        <a href="/movie/${item.db_id}" style="display:flex; align-items:center; gap:10px; padding:5px 0;">
                                            <img src="${item.image_url}" alt="${item.title}" width="60">
                                            <p>${item.title}</p>
                                        </a>
                                    `;
                                } else {
                                    console.warn("Missing db_id for result", item);
                                }
                            });

                            // Add "View All Results" button
                            results += `
                                <div style="margin-top:10px; display:flex; justify-content:center;">
                                    <a href="/search/movies/all?query=${encodeURIComponent(query)}" style="display:inline-block; padding:5px 10px; background:rebeccapurple; color:white; border-radius:20px; text-decoration:none;">
                                        View All Results
                                    </a>
                                </div>
                            `;
                        } else {
                            results = '<p>No results found</p>';
                        }

                        $('#results').html(results);
                    },
                    error: function () {
                        $('#results').html('<p>Error fetching data</p>');
                    }
                });

            }, 300);
        });
    });
</script>