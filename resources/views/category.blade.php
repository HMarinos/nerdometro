<section>
    @php
    $category = Route::current()->parameter('category');
    @endphp


    <h1>My {{$category}} library</h1>
    <ul>
        <li>add watched {{$category}} </li>
        <li>add to watch {{$category}} </li>
    </ul>

    <div class="list">
        <div class="flex">
            @component('components.media-card')
            @endcomponent
        </div>
        <div class="results">
            @foreach($movies as $movie)
            <div class="movie">
                
                {{-- <h2>{{ $movie['title'] }}</h2>
                <p>{{ $movie['overview'] }}</p> --}}
                <!-- Add more movie details as needed -->
            </div>
        @endforeach
        </div>
    </div>
</section>