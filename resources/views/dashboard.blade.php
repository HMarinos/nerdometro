<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 flex flex-col items-center justify-center gap-6 flex-wrap">
        <h2>My lists</h2>
        <div class="flex flex-wrap items-center justify-center gap-4">
            @foreach (['Anime', 'Games', 'Movies'] as $title)
                @component('components.category-card', ['cat_title' => $title, 'cat_link' => strtolower($title)])
                @endcomponent
            @endforeach
        </div>
    </div>
    <div class="mb-72">
        <h2 class="text-center">Popular</h2>
        @component('components.popular-tabs', ['movies' => $movies, 'anime' => $anime, 'games' => $games])
        @endcomponent
    </div>

</x-app-layout>
