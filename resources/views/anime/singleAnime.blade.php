<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section class="single single-anime">
        @if($anime && isset($anime['mal_id']))
        <div class="info">
            <div class="flex items-center justify-between">
                <h1>{{ $anime['title'] }}</h1>
                <div class="actions flex items-center gap-4">

                    {{-- add to watchlist --}}           
                    <form action="{{ route('anime.add.wishlist') }}" method="POST" class="flex items-center justify-centers m-0">
                        @csrf
                        <input type="hidden" name="data_title" value="{{ $anime['title'] }}">
                        <input type="hidden" name="data_id" value="{{ $anime['mal_id'] }}">
                        <input type="hidden" name="data_image" value="{{ $anime['images']['jpg']['image_url'] }}">
                        <button title="{{ $in_wishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                            <i style="color:{{ $in_wishlist ? 'orange' : '' }}" class="fa-solid fa-eye text-lg"></i>
                        </button>
                    </form>   
                    {{-- add anime --}}
                    <form action="{{ route('anime.add') }}" method="POST" class="flex items-center justify-centers m-0">
                        @csrf
                        <input type="hidden" name="data_title" value="{{ $anime['title'] }}">
                        <input type="hidden" name="data_id" value="{{ $anime['mal_id'] }}">
                        <input type="hidden" name="data_image" value="{{ $anime['images']['jpg']['image_url'] }}">
                        <input type="hidden" name="data_genres" value='@json($anime["genres"])'>
                        <input type="hidden" name="data_episodes" value="{{ $anime['episodes'] }}">
                        <input type="hidden" name="data_duration" value="{{ $anime['duration'] }}">
                        <input type="hidden" name="data_score" value="{{ $anime['score'] }}">
                        <button title="{{ $exists ? 'Remove from Watched' : 'Add to Watched' }}">
                            <i style="color:{{ $exists ? 'green' : '' }}" class="fa-solid fa-circle-check text-lg"></i>
                        </button>
                    </form>         

                </div>
            </div>
            <div class="top-bar">
                <ul>
                    <li>{{$anime['year'] ?? '-'}}</li>
                    <li>{{$anime['type'] ?? '-'}}</li>
                    <li class="flex items-center gap-2">
                        <svg class="fill-[#ffa534] aspect-square w-[16px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
                        {{ number_format($anime['score'], 1) ?? 'N/A' }}/10
                    </li>
                </ul>
            </div>
        <div>
        <div class="media flex flex-col lg:flex-row">
            <img class="max-w-[250px] object-cover" src="{{ $anime['images']['jpg']['image_url'] }}" alt="">
            <iframe class="w-full h-auto min-h-[315px] max-w-[600px]" width="560" height="315" controls=0  src="{{$anime['trailer']['embed_url']}}" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
        <div class="details">
            <ul class="genres flex flex-wrap items-center justify-start">
                @if(isset($anime['genres']))
                    @foreach($anime['genres'] as $genre)
                    <li>{{$genre['name'] ?? '-'}}</li>
                    @endforeach
                @endif
            </ul>
            <ul class="mb-4">
                <li class="py-[0.2rem]">{{$anime['rating'] ?? '-'}}</li>
                <li class="py-[0.2rem]">{{$anime['episodes'] ?? '-'}} episodes</li>
            </ul>
            <div>{{$anime['synopsis'] ?? '-'}}</div>
        </div>
        @else
            <div class="max-w-[800px] mx-auto flex items-center justify-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="uppercase text-xl mb-4">Anime not found</div>
                    <a href="/category/anime" class="underline text-center uppercase hover:text-animecolor transition-all">go back</a>
                </div>
            </div>
        @endif
    </section>

</x-app-layout>