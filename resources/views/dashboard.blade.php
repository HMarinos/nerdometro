<x-app-layout class="!p-0">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- <div class="py-12 flex flex-col items-center justify-center gap-6 flex-wrap">
        <h2>My lists</h2>
        <div class="flex flex-wrap items-center justify-center gap-4">
            @foreach (['Anime', 'Games', 'Movies'] as $title)
                @component('components.category-card', ['cat_title' => $title, 'cat_link' => strtolower($title)])
                @endcomponent
            @endforeach
        </div>
    </div> --}}
    {{-- <div class="mb-72">
        <h2 class="text-center">Popular</h2>
        @component('components.popular-tabs', ['movies' => $movies, 'anime' => $anime, 'games' => $games])
        @endcomponent
    </div> --}}

    <div class="grid grid-cols-1 lg:grid-cols-3 h-[calc(100vh-70px)]">
        <a href="/category/anime" class="relative flex items-end justify-center group transition-all overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-black/100 pointer-events-none transition-all z-[2]"></div>
            <img class="absolute hidden lg:block inset-0 z-[1] group-hover:scale-[1.1] transition-all w-full h-full object-cover" src="/images/dragonball_vertical.jpg" alt="">
            <img class="absolute lg:hidden inset-0 z-[1] group-hover:scale-[1.1] transition-all w-full h-full object-cover" src="/images/pain.jpg" alt="">
            <div class="text-[1.8rem] sm:text-[2rem] lg:text-[2.4rem] uppercase font-black text-animecolor relative z-[3] lg:group-hover:text-[3rem] transition-all mb-[15%] rounded-lg px-[10px] py-0 bg-[rgba(255,255,255,0.1)] backdrop-blur-md">anime</div>
        </a>
        <a href="category/movies" class="relative flex items-end justify-center group transition-all overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-black/100 pointer-events-none transition-all z-[2]"></div>
            <img class="absolute hidden lg:block inset-0 z-[1] group-hover:scale-[1.1] transition-all w-full h-full object-cover" src="/images/thematrix_vertical.jpg" alt="">
            <img class="absolute lg:hidden inset-0 z-[1] group-hover:scale-[1.1] transition-all w-full h-full object-cover" src="/images/taxidriver.jpg" alt="">
            <div class="text-[1.8rem] sm:text-[2rem] lg:text-[2.4rem] uppercase font-black text-moviecolor relative z-[3] lg:group-hover:text-[3rem] transition-all mb-[15%] rounded-lg px-[10px] py-0 bg-[rgba(255,255,255,0.1)] backdrop-blur-md">movies</div>
        </a>
        <a href="category/games" class="relative flex items-end justify-center group transition-all overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-black/100 pointer-events-none transition-all z-[2]"></div>
            <img class="absolute hidden lg:block inset-0 z-[1] group-hover:scale-[1.1] transition-all w-full h-full object-cover" src="/images/thewitcher_vertical.jpg" alt="">
            <img class="absolute lg:hidden inset-0 z-[1] group-hover:scale-[1.1] transition-all w-full h-full object-cover" src="/images/gta.webp" alt="">
            <div class="text-[1.8rem] sm:text-[2rem] lg:text-[2.4rem] uppercase font-black text-gamecolor relative z-[3] lg:group-hover:text-[3rem] transition-all mb-[15%] rounded-lg px-[10px] py-0 bg-[rgba(255,255,255,0.1)] backdrop-blur-md">games</div>
        </a>
    </div>

</x-app-layout>

