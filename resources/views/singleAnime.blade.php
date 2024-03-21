<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section class="single single-anime">
        <div class="info">
            <h1>{{ $anime['title'] }}</h1>
            <div class="top-bar">
                <ul>
                    <li>{{$anime['year']}}</li>
                    <li>{{$anime['type']}}</li>
                    <li>{{$anime['score']}}/10</li>
                </ul>
            </div>
        <div>
        <div class="media">
            <img src="{{ $anime['images']['jpg']['image_url'] }}" alt="">
            <iframe width="600" height="300" controls  src="{{$anime['trailer']['embed_url']}}" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
        <div class="details">
            <ul class="genres">
                @foreach($anime['genres'] as $genre)
                <li>{{$genre['name']}}</li>
                @endforeach
            </ul>
            <ul>
                <li>{{$anime['rating']}}</li>
                <li>{{$anime['episodes']}} episodes</li>
            </ul>
            <div>{{$anime['synopsis']}}</div>
        </div>
    </section>

</x-app-layout>