<section>
    <img src="" alt="">
    <div class="info">
        <h1>{{ $anime['title'] }}</h1>
        <div>
            <ul>
                <li>{{$anime['year']}}</li>
                <li>{{$anime['type']}}</li>
                
                
                <li>{{$anime['score']}}/10</li>
            </ul>
        </div>
    <div>
    <div class="media">
        <img src="{{ $anime['images']['jpg']['image_url'] }}" alt="">
        <iframe width="600" height="300" src="{{$anime['trailer']['embed_url']}}"></iframe>
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
    </div>
</section>
