<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section>
        <h1 class="text-center mb-16">My Games List</h1>
        <form class="text-center" method="GET" action="#" id="game-search-form">
            <input id="game-search-input" class="text-[rebeccapurple] shadow-[rebeccapurple] shadow-md bg-white rounded-[100px] h-[45px] pr-[50px]" type="text" placeholder="search.." name="search" value="{{request('search')}}"> 
            <button class="-ml-[50px] h-[45px] bg-[rgba(0,0,0,0.2)] w-[45px] rounded-full scale-[0.8] group hover:bg-[rebeccapurple] transition-all"><i class="fa-solid fa-magnifying-glass text-[rebeccapurple] group-hover:text-white transition-all"></i></button>
        </form>
        @csrf

        <div id="results" class="max-w-[400px] mx-auto flex flex-col gap-2 max-h-[350px] overflow-auto mt-4">
        </div>
    </section>

    <section class="mt-20 tabcontent">
        <div class="mb-8 px-4">
            I've played :
        </div>
        @if(isset($watched) && $watched)
        <ul class="grid grid-cols-5 gap-6 ">
            @foreach ($watched as $item)
                <li class="rounded-lg border relative cursor-pointer flex flex-col justify-between items-center group overflow-hidden">
                    <img src="{{$item['image_url'] ?? $item['cover']}}" alt="game image" class="w-full h-auto rounded-[4px_4px_0_0] transition-all">
                    <div class="title decoration-[rebeccapurple] group-hover:underline">
                        <a href="/game/{{$item['db_id'] ?? $item['id']}}">{{$item['title'] ?? $item['name']}}</a>
                    </div>

                    <form action="{{route('game.delete',$item->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-[30px] h-[30px] absolute top-[10px] left-[10px] rounded-full flex justify-center items-center border border-red-600 bg-red-600 z-[10] opacity-0 group-hover:opacity-100 transition-all"><i class="fa-solid fa-xmark"></i></button>
                    </form>
                </li>
            @endforeach
        </ul>
        @endif
    </section>

    <section class="mt-20 tabcontent">
        <div class="mb-8 px-4">
            Wishlist :
        </div>
        @if(isset($wishlisted) && $wishlisted)
        <ul class="grid grid-cols-5 gap-6 ">
            @foreach ($wishlisted as $item)
                <li class="rounded-lg border relative cursor-pointer flex flex-col justify-between items-center group overflow-hidden">
                    <img src="{{$item['image_url'] ?? $item['cover']}}" alt="game image" class="w-full h-auto rounded-[4px_4px_0_0] transition-all">
                    <div class="title decoration-[rebeccapurple] group-hover:underline">
                        <a href="/game/{{$item['db_id'] ?? $item['id']}}">{{$item['title'] ?? $item['name']}}</a>
                    </div>

                    <form action="{{route('game.remove.wishlist',$item->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-[30px] h-[30px] absolute top-[10px] left-[10px] rounded-full flex justify-center items-center border border-red-600 bg-red-600 z-[10] opacity-0 group-hover:opacity-100 transition-all"><i class="fa-solid fa-xmark"></i></button>
                    </form>
                </li>
            @endforeach
        </ul>
        @endif
    </section>
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  

<script>
    $(document).ready(function () {
        let debounceTimer;

        $('#game-search-input').on('keyup', function () {
            clearTimeout(debounceTimer); // clear previous timer

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
                                results += `
                                    <a href="/game/${item.db_id || item.id}" style="display:flex; align-items:center; gap:10px; padding:5px 0;">
                                        <img src="${item.image_url || item.cover}" alt="${item.title || item.name}" width="60">
                                        <p>${item.title || item.name}</p>
                                    </a>
                                `;
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
