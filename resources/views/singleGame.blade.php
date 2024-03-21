<section class="single single-game">
    <div class="info">
        <h1>{{$game['name']}}</h1>
        <div>
            <ul>
                <li>{{$game['released']}}</li>
                <li>{{$game['rating']*2}}/10</li>
            </ul>
        </div>
        <div class="media">
            <img src="{{$game['background_image']}}" alt="">
        </div>
        <div class="details">
            <ul class="genres">
                @foreach($game['genres'] as $genre)
                <li>{{$genre['name']}}</li>
                @endforeach
            </ul>
            <ul>
                <li>{{$game['esrb_rating']['name']}}</li>
            </ul>
            <ul>
                @foreach($game['platforms'] as $platform)
                <li>{{$platform['platform']['name']}}</li>
                @endforeach
            </ul>
            <div>{{$game['description']}}</div>
        </div>
    </div>
</section>