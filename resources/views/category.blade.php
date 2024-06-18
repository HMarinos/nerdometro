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

        {{-- <div class="list">
            <div class="flex">
                @component('components.media-card')
                @endcomponent
            </div>
        </div> --}}
        <form class="text-center" method="GET" action="#">
            <input class="text-[rebeccapurple]" type="text" placeholder="search.." name="search" value="{{request('search')}}"> 
            <button>search</button>
        </form>
        <ul class="flex flex-col items-center anime-list">
            @foreach ($anime_results as $anime)
            <li data-title="{{$anime}}" class="anime-item flex items-center gap-4 group cursor-pointer transition-all hover:text-green-200">{{$anime}}<span class="flex justify-center items-center text-green-600 w-6 h-6 border border-green-600 rounded-full group-hover:bg-green-600 group-hover:text-white transition-all font-bold">+</span></li>
            @endforeach
        </ul>
    </section>

    <section class="mt-20">
        <ul class="flex flex-wrap items-center justify-start gap-6">
            <li class="border border-purple-600 aspect-square w-[200px] rounded-xl text-center">tesetset</li>
            <li class="border border-purple-600 aspect-square w-[200px] rounded-xl text-center">tesetset</li>
            <li class="border border-purple-600 aspect-square w-[200px] rounded-xl text-center">tesetset</li>
            <li class="border border-purple-600 aspect-square w-[200px] rounded-xl text-center">tesetset</li>
            <li class="border border-purple-600 aspect-square w-[200px] rounded-xl text-center">tesetset</li>
            <li class="border border-purple-600 aspect-square w-[200px] rounded-xl text-center">tesetset</li>
            <li class="border border-purple-600 aspect-square w-[200px] rounded-xl text-center">tesetset</li>
        </ul>
    </section>
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  </head>

<script>
$(document).ready(function() {
    $('.anime-item').click(function() {
        var itemValue = $(this).data('title'); // Use data-title instead of data-value

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

        xhr.send(JSON.stringify({ value: itemValue }));
    });
});

</script>
