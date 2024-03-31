<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <section class="single single-movie">
        <img src="" alt="">
        <div class="info">
            <h1>{{$movie['title']}}</h1>
            <div class="top-bar">
                <ul>
                    <li>{{$movie['release_date']}}</li>
                    <li>{{$movie['runtime']}} minutes</li>
                    <li class="flex items-center gap-2">
                        <svg class="fill-[#ffa534] aspect-square w-[16px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
                        {{$movie['vote_average']}}/10
                    </li>
                </ul>
            </div>
        <div>
        <div class="media">
            <img src="{{ 'https://image.tmdb.org/t/p/w500/' . $movie['poster_path'] }}" alt="">
            <iframe width="560" height="315" controls=0 src="https://www.youtube.com/embed/{{$video['key']}}?si=-MvG6LyMyhOJ7Kir" title="YouTube video player" frameborder="0" allow="accelerometer;  clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
        <div class="details">
            <ul class="genres">
                @foreach ($movie['genres'] as $genre)
                    <li>{{$genre['name']}}</li>
                @endforeach
            </ul>
            <ul>
                <li></li>
                <li></li>
            </ul>
            <div>{{$movie['overview']}}</div>
        </div>
    </section>
</x-app-layout>