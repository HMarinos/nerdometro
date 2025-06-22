<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section>
        <h1 class="text-center mb-16">All results</h1>
        <form class="text-center" method="GET" action="#" id="anime-search-form">
            <input id="anime-search-input" class="text-[rebeccapurple] shadow-[rebeccapurple] shadow-md bg-white rounded-[100px] h-[45px] pr-[50px]" type="text" placeholder="search.." name="search" value="{{request('search')}}"> 
            <button class="-ml-[50px] h-[45px] bg-[rgba(0,0,0,0.2)] w-[45px] rounded-full scale-[0.8] group hover:bg-[rebeccapurple] transition-all"><i class="fa-solid fa-magnifying-glass text-[rebeccapurple] group-hover:text-white transition-all"></i></button>
        </form>
        @csrf

        <div id="results" class="max-w-[400px] mx-auto flex flex-col gap-2 max-h-[350px] overflow-auto">
        </div>
    </section>

    <section class="mt-20 tabcontent">
        <div class="mb-8 px-4">
            Seeing results for: {{ $query }}
        </div>
        @if(isset($results) && $results)
        <ul class="grid grid-cols-5 gap-6 ">
            @foreach ($results as $item)
                <li class="rounded-lg border relative cursor-pointer flex flex-col justify-between items-center group overflow-hidden">
                    <img src="{{$item['image_url']}}" alt="anime image" class="w-full h-auto rounded-[4px_4px_0_0] transition-all">
                    <div class="title decoration-[rebeccapurple] group-hover:underline">
                        <a href="/anime/{{$item['mal_id']}}">{{$item['title']}}</a>
                    </div>

                    @php
                        $in_wishlist = in_array($item['mal_id'], $userWishlistIds ?? []);
                        dump($item['mal_id']);
                    @endphp
                    
                    <form action="{{ route('anime.add.wishlist') }}" method="POST" class="flex items-center m-0">
                        @csrf
                        <input type="hidden" name="data_title" value="{{ $item['title'] }}">
                        <input type="hidden" name="data_id" value="{{ $item['mal_id'] }}">
                        <input type="hidden" name="data_image" value="{{ $item['image_url'] }}">
                        <button type="submit" title="{{ $in_wishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}" class="focus:outline-none">
                            <i class="fa-solid fa-eye text-lg" style="color: {{ $in_wishlist ? 'orange' : 'inherit' }}"></i>
                        </button>
                    </form>

                </li>
            @endforeach
        </ul>
        @endif

        @if ($pagination && $pagination['last_visible_page'] > 1)
            <div class="mt-4 flex flex-wrap gap-2 justify-center">
                {{-- Previous --}}
                @if ($pagination['current_page'] > 1)
                <a href="{{ url()->current() }}?query={{ urlencode($query) }}&page={{ $pagination['current_page'] - 1 }}"
                    class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">Previous</a>
                @endif

                {{-- Page numbers --}}
                @for ($i = 1; $i <= $pagination['last_visible_page']; $i++)
                    <a href="{{ url()->current() }}?query={{ urlencode($query) }}&page={{ $i }}"
                    class="px-3 py-1 rounded 
                        {{ $i == $pagination['current_page'] 
                            ? 'bg-[rebeccapurple] text-white border-b border-[rebeccapurple]' 
                            : 'bg-gray-200 hover:bg-gray-300' }}">
                    {{ $i }}
                    </a>
                @endfor

                {{-- Next --}}
                @if ($pagination['has_next_page'])
                    <a href="{{ url()->current() }}?query={{ urlencode($query) }}&page={{ $pagination['current_page'] + 1 }}"
                    class="px-3 py-1 bg-[rebeccapurple] text-white rounded hover:bg-purple-700">Next</a>
                @endif
            </div>
        @endif

    </section>

</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  

<script>
    $(document).ready(function () {
        let debounceTimer;

        $('#anime-search-input').on('keyup', function () {
            clearTimeout(debounceTimer); // clear previous timer

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
                                <div style="margin-top:10px;">
                                    <a href="/search/anime/all?query=${encodeURIComponent(query)}" style="display:inline-block; padding:5px 10px; background:#007bff; color:white; border-radius:4px; text-decoration:none;">
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