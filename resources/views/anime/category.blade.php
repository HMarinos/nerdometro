<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section>
        <h1 class="text-center mb-12 text-animecolor text-[1.6rem] lg:text-[2rem] uppercase font-bold">Anime</h1>
        <div class="relative">
            <form class="text-center max-w-[768px] mx-auto flex items-center" method="GET" action="#" id="anime-search-form">
                <input id="anime-search-input" class="text-animecolor shadow-animecolor shadow-md bg-white rounded-[100px] h-[45px] pr-[50px] w-full" type="text" placeholder="search.." name="search" value="{{request('search')}}">
                <button class="-ml-[50px] h-[45px] bg-[rgba(0,0,0,0.1)] w-[45px] rounded-full scale-[0.8] group hover:bg-animecolor transition-all"><i class="fa-solid fa-magnifying-glass text-animecolor group-hover:text-white transition-all"></i></button>
            </form>
            @csrf
            <div id="results" class="max-w-[768px] mx-auto flex flex-col gap-2 max-h-[450px] overflow-auto mt-4 absolute top-[50px] left-[50%] translate-x-[-50%] bg-[rgba(0,0,0,0.8)] px-4 z-[10] backdrop-blur-[10px] shadow-[0 0 20px white]">
            </div>
        </div>
    </section>

    <section class="mb-12 mt-8 bg-[rgba(255,255,255,0.05)] rounded-lg p-4">
        <h2 class="flex items-center justify-start mb-2"><span class="w-[8px] h-[8px] bg-red-500 rounded-full mr-2"></span><span>Best of all time</span></h2>
        <div class="tabcontent anime">
            <div class="swiper animeswiper1">
                <div class="swiper-wrapper">
                    @foreach ($anime_global as $global)
                        <div class="swiper-slide cont">
                            <div class="rounded-lg item flex flex-col justify-between items-center group overflow-hidden">
                                <a  href="/anime/{{ $global['mal_id'] }}">
                                    <img class="w-full h-auto rounded-[4px_4px_0_0] transition-all"
                                        src="{{ $global['images']['jpg']['large_image_url'] }}" alt="">
                                    <div class="title">
                                        <span class="z-20">{{ $global['title'] ?? '-' }}</span>
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
        <h2 class="flex items-center justify-start mb-2"><span class="w-[8px] h-[8px] bg-red-500 rounded-full mr-2"></span>Top airing</h2>
        <div class="tabcontent anime">
            <div class="swiper animeswiper2">
                <div class="swiper-wrapper">
                    @foreach ($anime_airing as $airing)
                        <div class="swiper-slide cont">
                            <div class="rounded-lg item flex flex-col justify-between items-center group overflow-hidden">
                                <a href="/anime/{{ $airing['mal_id'] }}">
                                    <img class="w-full h-auto rounded-[4px_4px_0_0] transition-all"
                                        src="{{ $airing['images']['jpg']['large_image_url'] }}" alt="">
                                    <div class="title">
                                        <span class="z-20">{{ $airing['title'] ?? '-' }}</span>
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
        <h2 class="flex items-center justify-start mb-2"><span class="w-[8px] h-[8px] bg-red-500 rounded-full mr-2"></span>Characters</h2>
        <div class="tabcontent anime">
            <div class="swiper animeswiper3">
                <div class="swiper-wrapper">
                    @foreach ($anime_characters as $character)
                    <div class="swiper-slide rounded-md">
                        <div class="flex flex-col md:flex-row items-start">
                            <div class="flex pr-4 pb-4 gap-2">
                                <img src="{{$character['images']['webp']['image_url'] ?? '-'}}" alt="" class="rounded-md max-w-[142px]">
                                <div>
                                    <div>
                                        <div class="">
                                            <div class="text-animecolor uppercase mb-4 font-medium text-nowrap ">{{$character['name'] ?? '-'}}</div>
                                            <ul class="ml-1">
                                                @if(isset($character['nicknames']))
                                                    @foreach($character['nicknames'] as $nickname)
                                                    <li class="text-xs text-animecolor/90 mb-1">{{$nickname ?? '-'}}</li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-sm max-h-[250px] overflow-y-auto">{{$character['about'] ?? '-'}}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  

<script>
    $(document).ready(function () {
        let debounceTimer;

        $('#anime-search-input').on('keyup', function () {
            clearTimeout(debounceTimer);

            let query = $(this).val();

            debounceTimer = setTimeout(() => {
                if (query.length < 3) {
                    $('#results').html('');
                    return;
                }

                let searchUrl = `/search/anime?query=${query}`;

                $.ajax({
                    url: searchUrl,
                    type: "GET",
                    success: function (data) {
                        let results = '';
                        if (data.length > 0) {
                            data.forEach(item => {
                                results += `
                                    <a href="/anime/${item.db_id}" style="display:flex; align-items:center; gap:10px; padding:5px 0;">
                                        <img src="${item.image_url}" alt="${item.title}" width="60">
                                        <p>${item.title}</p>
                                    </a>
                                `;
                            });

                            // Add "View All Results" button
                            results += `
                                <div style="margin-top:10px; padding-bottom:30px; display:flex; justify-content:center; position:sticky; bottom:0;">
                                    <a href="/search/anime/all?query=${encodeURIComponent(query)}" style="display:inline-block; padding:5px 10px; background:#dc2626; color:white; border-radius:20px; text-decoration:none;">
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
