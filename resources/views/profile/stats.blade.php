<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section class="">
        <div class="grid grid-cols-2 gap-8">
            <div>
                <h2 class="leading-none h-8 translate-y-4 text-[rebeccapurple] bg-[#121212] inline-flex px-2 ml-4 pointer-evens-none">anime stats</h2>
                <div class="border border-[rebeccapurple] rounded-xl p-8">
                    <div class="grid grid-cols-2">
                        <div>
                            <div>total anime watched</div>
                            <div>total episodes watched</div>
                            <div>total time spent</div>
                        </div>
                        <div>
                            <div>{{$total_anime_watched}}</div>
                            <div>1</div>
                            <div>1</div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <x-chartjs-component :chart="$chartAnime" />
                    </div>
                </div>
            </div>
            <div>
                <h2 class="leading-none h-8 translate-y-4 text-[rebeccapurple] bg-[#121212] inline-flex px-2 ml-4 pointer-evens-none">movie stats</h2>
                <div class="border border-[rebeccapurple] rounded-xl p-8">
                    <div class="grid grid-cols-2">
                        <div>
                            <div>total movies watched</div>
                            <div>total time spent</div>
                        </div>
                        <div>
                            <div>1</div>
                            <div>1</div>
                            <div>1</div>
                        </div>
                    </div>
                    <div class="mt-8">
                        categories graph here
                    </div>
                </div>
            </div>
            <div>
                <h2 class="leading-none h-8 translate-y-4 text-[rebeccapurple] bg-[#121212] inline-flex px-2 ml-4 pointer-evens-none">games stats</h2>
                <div class="border border-[rebeccapurple] rounded-xl p-8">
                    <div class="grid grid-cols-2">
                        <div>
                            <div>total movies watched</div>
                            <div>total time spent</div>
                        </div>
                        <div>
                            <div>1</div>
                            <div>1</div>
                            <div>1</div>
                        </div>
                    </div>
                    <div class="mt-8">
                        categories graph here
                    </div>
                </div>
            </div>
            <div>
                Fun facts
                <div>fan favorite you haven't touched 0.0</div>
                <div>nostalgia trip / percentage of classics vs new</div>
            </div>
        </div>
    </section>

</x-app-layout>