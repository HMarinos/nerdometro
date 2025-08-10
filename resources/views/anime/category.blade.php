<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section>
        <h1 class="text-center mb-12 text-animecolor text-[2rem] uppercase font-bold">Anime</h1>
        <form class="text-center max-w-[768px] mx-auto flex items-center" method="GET" action="#" id="game-search-form">
            <input id="game-search-input" class="text-animecolor shadow-animecolor shadow-md bg-white rounded-[100px] h-[45px] pr-[50px] w-full" type="text" placeholder="search.." name="search" value="{{request('search')}}"> 
            <button class="-ml-[50px] h-[45px] bg-[rgba(0,0,0,0.1)] w-[45px] rounded-full scale-[0.8] group hover:bg-animecolor transition-all"><i class="fa-solid fa-magnifying-glass text-animecolor group-hover:text-white transition-all"></i></button>
        </form>
        @csrf

        <div id="results" class="max-w-[400px] mx-auto flex flex-col gap-2 max-h-[350px] overflow-auto mt-4">
        </div>
    </section>

    <section class="mb-12">
        <h2>Best of all time</h2>
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
                                        <span class="z-20">{{ $global['title'] }}</span>
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

    <section>
        <h2>Top airing</h2>
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
                                        <span class="z-20">{{ $airing['title'] }}</span>
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

    <section>
        <h2>Characters</h2>
        <div class="tabcontent anime">
            <div class="swiper animeswiper3">
                <div class="swiper-wrapper">
                    @foreach ($anime_characters as $character)
                    <div class="swiper-slide border-2 shadow-[inset_0_0_10px_red] border-animecolor rounded-md p-4">
                        <div>
                            <div class="flex float-left pr-4 pb-4 gap-2">
                                <img src="{{$character['images']['webp']['image_url']}}" alt="" class="rounded-md max-w-[164px]">
                                <div>
                                    @if($character['nicknames'] && !empty($character['nicknames']))
                                    <div>
                                        <div class="text-animecolor uppercase mb-4 font-medium">{{$character['name']}}</div>
                                        <ul class="ml-1">
                                            @foreach($character['nicknames'] as $nickname)
                                            <li class="text-xs text-animecolor/80 mb-1">{{$nickname}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-sm">{{$character['about']}}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>



</x-app-layout>
