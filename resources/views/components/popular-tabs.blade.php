<div class="tab overflow-hidden flex items-center justify-center gap-4">
    <button class="tablinks" onclick="openCity(event, 'Movies')">Movies</button>
    <button class="tablinks" onclick="openCity(event, 'Anime')">Anime</button>
    <button class="tablinks" onclick="openCity(event, 'Games')">Games</button>
</div>
<div id="Movies" class="tabcontent">
    <ul class="flex flex-wrap justify-center gap-4">
        @foreach ($movies as $movie)
            <li>
                {{ $movie['title'] }}
                <img src="{{ 'https://image.tmdb.org/t/p/w500/' . $movie['poster_path'] }}">
            </li>
        @endforeach
    </ul>
</div>

<div id="Anime" class="tabcontent hidden">
    <ul class="flex flex-wrap justify-center gap-4">
        @foreach ($anime as $anime)
            <li>{{ $anime['title'] }}</li>
            <img src="{{ $anime['images']['jpg']['large_image_url'] }}" alt="">
        @endforeach
    </ul>
</div>

<div id="Games" class="tabcontent hidden">
    <ul class="flex flex-wrap justify-center gap-4">
        @foreach ($games as $game)
            <li>{{ $game['name'] }}</li>
            <img src="{{ $game['background_image'] }}" alt="">
        @endforeach
    </ul>
</div>


<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
