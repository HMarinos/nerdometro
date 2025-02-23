<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section>
        @php
        $category = Route::current()->parameter('category');
        @endphp


        <h1 class="text-center mb-16">My {{$category}} library</h1>
        <form class="text-center" method="GET" action="#">
            <input class="text-[rebeccapurple]" type="text" placeholder="search.." name="search" value="{{request('search')}}"> 
            <button>search</button>
        </form>
        @csrf

        @if($category == 'anime')
        <ul class="flex flex-col items-center anime-list">
            @foreach ($anime_results as $anime)
            <li data-title="{{$anime['title']}}" data-image="{{$anime['image_url']}}" key="{{$anime['db_id']}}" class="anime-item flex items-center gap-4 group cursor-pointer transition-all hover:text-green-200">{{$anime['title']}}<span class="flex justify-center items-center text-green-600 w-6 h-6 border border-green-600 rounded-full group-hover:bg-green-600 group-hover:text-white transition-all font-bold">+</span></li>
            @endforeach
        </ul>
        @endif

        @if($category == 'movies')
        <ul class="flex flex-col items-center movie-list">
            @foreach ($movie_results as $movie)
            <li data-title="{{$movie['title']}}" data-image="{{$movie['image_url']}}" key="{{$movie['db_id']}}" class="movie-item flex items-center gap-4 group cursor-pointer transition-all hover:text-green-200">{{$movie['title']}}<span class="flex justify-center items-center text-green-600 w-6 h-6 border border-green-600 rounded-full group-hover:bg-green-600 group-hover:text-white transition-all font-bold">+</span></li>
            @endforeach
        </ul>
        @endif

        @if($category == 'games')
        <ul class="flex flex-col items-center game-list">
            @foreach ($game_results as $game)
            <li data-title="{{$game['title']}}" data-image="{{$game['image_url']}}" key="{{$game['db_id']}}" class="game-item flex items-center gap-4 group cursor-pointer transition-all hover:text-green-200">{{$game['title']}}<span class="flex justify-center items-center text-green-600 w-6 h-6 border border-green-600 rounded-full group-hover:bg-green-600 group-hover:text-white transition-all font-bold">+</span></li>
            @endforeach
        </ul>
        @endif

    </section>

    <section class="mt-20 tabcontent">
        @if(isset($anime_data) && $anime_data)
        <ul class="flex flex-wrap items-center justify-start gap-6">
            @foreach ($anime_data as $anime)
                <li class="rounded-lg border relative cursor-pointer flex flex-col justify-between items-center group overflow-hidden">
                    <img src="{{$anime['image_url']}}" alt="anime image" class="w-full h-auto rounded-[4px_4px_0_0] transition-all">
                    <div class="title">
                        <a href="/anime/{{$anime['db_id']}}">{{$anime['title']}}</a>
                    </div>

                    <form action="{{route('anime.delete',$anime->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-[30px] h-[30px] absolute top-[10px] left-[10px] rounded-full flex justify-center items-center border border-red-400 bg-red-400 z-[10]">x</button>
                    </form>
                </li>
            @endforeach
        </ul>
        @endif

        @if(isset($movie_data) && $movie_data)
        <ul class="flex flex-wrap items-center justify-start gap-6">
            @foreach ($movie_data as $movie)
                <li class="rounded-lg border relative cursor-pointer flex flex-col justify-between items-center group overflow-hidden">
                    <img src="{{$movie['image_url']}}" alt="movie image" class="w-full h-auto rounded-[4px_4px_0_0] transition-all">
                    <div class="title">
                        <a href="/movie/{{$movie['db_id']}}">{{$movie['title']}}</a>
                    </div>

                    <form action="{{route('movie.delete',$movie->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-[30px] h-[30px] absolute top-[10px] left-[10px] rounded-full flex justify-center items-center border border-red-400 bg-red-400 z-[10]">x</button>
                    </form>
                </li>            
            @endforeach
        </ul>
        @endif

        @if(isset($game_data) && $game_data)
        <ul class="flex flex-wrap items-center justify-start gap-6">
            @foreach ($game_data as $game)
                <li class="rounded-lg border relative cursor-pointer flex flex-col justify-between items-center group overflow-hidden">
                    <img src="{{$game['image_url']}}" alt="game image" class="w-full h-auto rounded-[4px_4px_0_0] transition-all">
                    <div class="title">
                        <a href="/game/{{$game['db_id']}}">{{$game['title']}}</a>
                    </div>

                    <form action="{{route('game.delete',$game->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-[30px] h-[30px] absolute top-[10px] left-[10px] rounded-full flex justify-center items-center border border-red-400 bg-red-400 z-[10]">x</button>
                    </form>
                </li>                
            @endforeach
        </ul>
        @endif

    </section>
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  


@if($category == 'anime')
<script>
    $(document).ready(function() {
        $('.anime-item').click(function() {
            var title = $(this).data('title'); // Use data-title instead of data-value
            var image = $(this).data('image');
            var db_id = $(this).attr('key');

            const xhr = new XMLHttpRequest();

            xhr.open('POST', '{{ route('anime.add') }}'); // Replace with your actual route
            xhr.setRequestHeader('Content-Type', 'application/json');  // Set header for JSON data
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);  // Include CSRF token

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Handle successful insertion (e.g., show a success message)
                        console.log('Item added successfully!');
                    } else {
                        // Handle errors (e.g., show an error message)
                        console.error('Error adding item:', response.message);
                    }
                } else {
                    console.error('AJAX Error:', xhr.statusText);
                }
            };

            xhr.onerror = function() {
                console.error('AJAX Error:', xhr.statusText);
            };

            xhr.send(JSON.stringify({ 
                data_title: title,
                data_image: image,
                data_id: db_id
             }));
        });
    });
</script>
@endif

@if($category == 'movies')
<script>
    $(document).ready(function() {
        $('.movie-item').click(function() {
            var title = $(this).data('title'); // Use data-title instead of data-value
            var image = $(this).data('image');
            var db_id = $(this).attr('key');

            const xhr = new XMLHttpRequest();

            xhr.open('POST', '{{ route('movie.add') }}'); // Replace with your actual route
            xhr.setRequestHeader('Content-Type', 'application/json');  // Set header for JSON data
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);  // Include CSRF token

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Handle successful insertion (e.g., show a success message)
                        console.log('Item added successfully!');
                    } else {
                        // Handle errors (e.g., show an error message)
                        console.error('Error adding item:', response.message);
                    }
                } else {
                    console.error('AJAX Error:', xhr.statusText);
                }
            };

            xhr.onerror = function() {
                console.error('AJAX Error:', xhr.statusText);
            };

            xhr.send(JSON.stringify({
                data_title: title,
                data_image: image,
                data_id: db_id
              }));
        });
    });
</script>
@endif


@if($category == 'games')
<script>
    $(document).ready(function() {
        $('.game-item').click(function() {
            var title = $(this).data('title'); // Use data-title instead of data-value
            var image = $(this).data('image');
            var db_id = $(this).attr('key');

            const xhr = new XMLHttpRequest();

            xhr.open('POST', '{{ route('game.add') }}'); // Replace with your actual route
            xhr.setRequestHeader('Content-Type', 'application/json');  // Set header for JSON data
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);  // Include CSRF token

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Handle successful insertion (e.g., show a success message)
                        console.log('Item added successfully!');
                    } else {
                        // Handle errors (e.g., show an error message)
                        console.error('Error adding item:', response.message);
                    }
                } else {
                    console.error('AJAX Error1:', xhr.statusText);
                }
            };

            xhr.onerror = function() {
                console.error('AJAX Error:', xhr.statusText);
            };

            xhr.send(JSON.stringify({
                data_title: title,
                data_image: image,
                data_id: db_id
              }));
        });
    });
</script>
@endif

