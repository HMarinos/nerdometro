<section class="single single-movie">
    <img src="" alt="">
    <div class="info">
        <h1>{{$movie['title']}}</h1>
        <div>
            <ul>
                <li>{{$movie['release_date']}}</li>
                <li>{{$movie['runtime']}} minutes</li>
                <li>{{$movie['vote_average']}}/10</li>
            </ul>
        </div>
    <div>
    <div class="media">
        <img src="{{ 'https://image.tmdb.org/t/p/w500/' . $movie['poster_path'] }}" alt="">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$video['key']}}?si=-MvG6LyMyhOJ7Kir" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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
