<div class="tab overflow-hidden flex items-center justify-center gap-6 pb-10 py-[1.5rem] mb-8">
    {{-- <button class="tablinks active" onclick="openCity(event, 'Movies')">Movies</button> --}}
    <button class="tablinks" onclick="openCity(event, 'Anime')">Anime</button>
    {{-- <button class="tablinks" onclick="openCity(event, 'Games')">Games</button> --}}
</div>
{{-- <div id="Movies" class="tabcontent">
    <ul class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach ($movies as $movie)
            <li
                class="rounded-lg border cursor-pointer flex flex-col justify-between items-center group overflow-hidden">
                <a href="/movie/{{$movie['id']}}">
                    <img class="w-full h-auto rounded-[4px_4px_0_0] transition-all"
                        src="{{ 'https://image.tmdb.org/t/p/w500/' . $movie['poster_path'] }}">
                    <div class="title">
                        <span >{{ $movie['title'] }}</span>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div> --}}

<div id="Anime" class="tabcontent">
    <ul class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach ($anime as $anime)
            <li class="rounded-lg flex flex-col justify-between items-center group overflow-hidden">
                <a  href="/anime/{{ $anime['mal_id'] }}">
                    <img class="w-full h-auto rounded-[4px_4px_0_0] transition-all"
                        src="{{ $anime['images']['jpg']['large_image_url'] }}" alt="">
                    <div class="title">
                        <span class="z-20">{{ $anime['title'] }}</span>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>

{{-- <div id="Games" class="tabcontent hidden">
    <ul class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach ($games as $game)
            <li class="rounded-lg cursor-pointer flex flex-col justify-between items-center group overflow-hidden">
                <a href="/game/{{$game['id']}}">
                    <img class="w-full h-auto rounded-[4px_4px_0_0] transition-all" src="{{ $game['background_image'] }}"
                        alt="">
                    <div class="title">
                        <span >{{ $game['name'] }}</span>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div> --}}


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
