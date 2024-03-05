<div class="tab overflow-hidden flex items-center justify-center gap-4">
    <button class="tablinks" onclick="openCity(event, 'Movies')">Movies</button>
    <button class="tablinks" onclick="openCity(event, 'Anime')">Anime</button>
    <button class="tablinks" onclick="openCity(event, 'Games')">Games</button>
</div>
<div id="Movies" class="tabcontent">
    <ul class="grid grid-cols-6 gap-4">
        @foreach ($movies as $movie)
            <li
                class="rounded-lg border cursor-pointer border-black bg-[rgba(255,255,255,0.2)] hover:bg-[rgba(0,0,0,0.2)] text-white flex flex-col justify-between items-center group overflow-hidden">
                <img class="w-full h-auto rounded-[4px_4px_0_0] contrast-75 group-hover:contrast-125 transition-all"
                    src="{{ 'https://image.tmdb.org/t/p/w500/' . $movie['poster_path'] }}">
                <div
                    class="title text-[14px] leading-4 px-2 py-4 flex items-center justify-center h-full text-center group-hover:tracking-wide transition-all">
                    {{ $movie['title'] }}</div>
            </li>
        @endforeach
    </ul>
</div>

<div id="Anime" class="tabcontent hidden">
    <ul class="grid grid-cols-6 gap-4">
        @foreach ($anime as $anime)
            <li
                class="rounded-lg border cursor-pointer border-black bg-[rgba(255,255,255,0.2)] hover:bg-[rgba(0,0,0,0.2)] text-white flex flex-col justify-between items-center group overflow-hidden">
                <img class="w-full h-auto rounded-[4px_4px_0_0] contrast-75 group-hover:contrast-125 transition-all"
                    src="{{ $anime['images']['jpg']['large_image_url'] }}" alt="">
                <div
                    class="title text-[14px] leading-4 p-2 flex items-center justify-center h-full text-center group-hover:tracking-wide transition-all">
                    {{ $anime['title'] }}</div>
            </li>
        @endforeach
    </ul>
</div>

<div id="Games" class="tabcontent hidden">
    <ul class="grid grid-cols-6 gap-4">
        @foreach ($games as $game)
            <li
                class="rounded-lg border cursor-pointer border-black bg-[rgba(255,255,255,0.2)] hover:bg-[rgba(0,0,0,0.2)] text-white flex flex-col justify-between items-center group overflow-hidden">
                <img class="w-full h-auto rounded-[4px_4px_0_0] contrast-75 group-hover:contrast-125 transition-all"
                    src="{{ $game['background_image'] }}" alt="">
                <div
                    class="title text-[14px] leading-4 p-2 flex items-center justify-center h-full text-center group-hover:tracking-wide transition-all">
                    {{ $game['name'] }}</div>
            </li>
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
