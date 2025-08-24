<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section>
        <h1 class="text-center mb-12 text-gamecolor text-[2rem] uppercase font-bold">Games</h1>
        <div class="relative">
            <form class="text-center max-w-[768px] mx-auto flex items-center" method="GET" action="#" id="game-search-form">
                <input id="game-search-input" class="text-gamecolor shadow-gamecolor shadow-md bg-white rounded-[100px] h-[45px] pr-[50px] w-full" type="text" placeholder="search.." name="search" value="{{request('search')}}">
                <button class="-ml-[50px] h-[45px] bg-[rgba(0,0,0,0.1)] w-[45px] rounded-full scale-[0.8] group hover:bg-gamecolor transition-all"><i class="fa-solid fa-magnifying-glass text-gamecolor group-hover:text-white transition-all"></i></button>
            </form>
            @csrf
            <div id="results" class="max-w-[768px] mx-auto flex flex-col gap-2 max-h-[450px] overflow-auto mt-4 absolute top-[50px] left-[50%] translate-x-[-50%] bg-[rgba(0,0,0,0.8)] px-4 z-[10] backdrop-blur-[10px] shadow-[0 0 20px white]">
            </div>
        </div>
    </section>

    <section class="mb-12 mt-8 bg-[rgba(255,255,255,0.05)] rounded-lg p-4">
        <h2 class="flex items-center justify-start mb-2"><span class="w-[8px] h-[8px] bg-gamecolor rounded-full mr-2"></span><span>Best of all time</span></h2>
        <div class="tabcontent game">
            <div class="swiper gameswiper1">
                <div class="swiper-wrapper">
                    @foreach ($top_games as $top)
                        <div class="swiper-slide cont">
                            <div class="rounded-lg item flex flex-col justify-between items-center group overflow-hidden">
                                <a href="/game/{{ $top['id'] }}">
                                    <img class="w-full h-auto rounded-[4px_4px_0_0] transition-all" src="{{ $top['background_image'] }}" alt="">
                                    <div class="title">
                                        <span class="z-20">{{ $top['name'] ?? '-' }}</span>
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

    <section class="mb-12 mt-8 bg-[rgba(255,255,255,0.05)] rounded-lg p-4">
        <h2 class="flex items-center justify-start mb-2"><span class="w-[8px] h-[8px] bg-gamecolor rounded-full mr-2"></span><span>Trending right now</span></h2>
        <div class="tabcontent game">
            <div class="swiper gameswiper2">
                <div class="swiper-wrapper">
                    @foreach ($trending_games as $trending)
                        <div class="swiper-slide cont">
                            <div class="rounded-lg item flex flex-col justify-between items-center group overflow-hidden">
                                <a href="/game/{{ $trending['id'] }}">
                                    <img class="w-full h-auto rounded-[4px_4px_0_0] transition-all" src="{{ $trending['background_image'] }}" alt="">
                                    <div class="title">
                                        <span class="z-20">{{ $trending['name'] ?? '-' }}</span>
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

    <section class="mb-12 mt-8 bg-[rgba(255,255,255,0.05)] rounded-lg p-4">
        <h2 class="flex items-center justify-start mb-2"><span class="w-[8px] h-[8px] bg-gamecolor rounded-full mr-2"></span><span>New releases</span></h2>
        <div class="tabcontent game">
            <div class="swiper gameswiper3">
                <div class="swiper-wrapper">
                    @foreach ($new_releases as $new)
                        <div class="swiper-slide cont">
                            <div class="rounded-lg item flex flex-col justify-between items-center group overflow-hidden">
                                <a href="/game/{{ $new['id'] }}">
                                    <img class="w-full h-auto rounded-[4px_4px_0_0] transition-all" src="{{ $new['background_image'] }}" alt="">
                                    <div class="title">
                                        <span class="z-20">{{ $new['name'] ?? '-' }}</span>
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

</x-app-layout>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  

<script>
    $(document).ready(function () {
        let debounceTimer;

        $('#game-search-input').on('keyup', function () {
            clearTimeout(debounceTimer);

            let query = $(this).val();

            debounceTimer = setTimeout(() => {
                if (query.length < 3) {
                    $('#results').html('');
                    return;
                }

                let searchUrl = `/search/games?query=${query}`;

                $.ajax({
                    url: searchUrl,
                    type: "GET",
                    success: function (data) {
                        let results = '';
                        if (data.length > 0) {
                            data.forEach(item => {
                                if (item.db_id) {
                                    results += `
                                        <a href="/game/${item.db_id}" style="display:flex; align-items:center; gap:10px; padding:5px 0;">
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
                                    <a href="/search/games/all?query=${encodeURIComponent(query)}" style="display:inline-block; padding:5px 10px; background:rebeccapurple; color:white; border-radius:20px; text-decoration:none;">
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