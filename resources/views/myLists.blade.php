<x-app-layout class="!p-0">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("tabsApp", () => ({
                activeTab: 'anime',
                tabs: [
                { id: 'anime', name: 'Anime', icon: 'monitor' },
                { id: 'movies', name: 'Movies', icon: 'film' },
                { id: 'games', name: 'Games', icon: 'gamepad-2' },
                ],
                setTab(id) {
                this.activeTab = id;
                },
            }));
        });
  </script>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50" x-data="tabsApp">
        <div class="container mx-auto px-4 py-8 max-w-4xl">
            <!-- Header -->
            <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">My Lists</h1>
            <p class="text-gray-600">Organize your entertainment library</p>
            </div>
        
            <!-- Tab Navigation -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 mb-8">
            <div class="flex space-x-1">
                <template x-for="tab in tabs" :key="tab.id">
                <button
                    @click="setTab(tab.id)"
                    class="flex items-center space-x-2 px-6 py-3 rounded-xl font-medium transition-all duration-200 flex-1 justify-center"
                    :class="activeTab === tab.id
                    ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/25 transform scale-[1.02]'
                    : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50'">
                    <span x-text="tab.name"></span>
                </button>
                </template>
            </div>
            </div>
        
            <!-- Tab Content -->
            <div class="transition-all duration-300 ease-in-out">
            <!-- Anime -->
            <template x-if="activeTab === 'anime'">
                <div class="space-y-8">
                <!-- My Completed -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                    My Completed
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-8 text-center">
                    <p class="text-gray-500">No completed anime yet</p>
                    <p class="text-sm text-gray-400 mt-1">Add your finished anime here</p>
                    </div>
                </div>
                <!-- For Future Me -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                    For Future Me
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-8 text-center">
                    <p class="text-gray-500">No anime in your watchlist</p>
                    <p class="text-sm text-gray-400 mt-1">Add anime you want to watch later</p>
                    </div>
                </div>
                </div>
            </template>
        
            <!-- Movies -->
            <template x-if="activeTab === 'movies'">
                <div class="space-y-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                    My Completed
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-8 text-center">
                    <p class="text-gray-500">No completed movies yet</p>
                    <p class="text-sm text-gray-400 mt-1">Add your finished movies here</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                    For Future Me
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-8 text-center">
                    <p class="text-gray-500">No movies in your watchlist</p>
                    <p class="text-sm text-gray-400 mt-1">Add movies you want to watch later</p>
                    </div>
                </div>
                </div>
            </template>
        
            <!-- Games -->
            <template x-if="activeTab === 'games'">
                <div class="space-y-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                    My Completed
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-8 text-center">
                    <p class="text-gray-500">No completed games yet</p>
                    <p class="text-sm text-gray-400 mt-1">Add your finished games here</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                    For Future Me
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-8 text-center">
                    <p class="text-gray-500">No games in your watchlist</p>
                    <p class="text-sm text-gray-400 mt-1">Add games you want to play later</p>
                    </div>
                </div>
                </div>
            </template>
            </div>
        
            <!-- Footer -->
            <div class="text-center mt-12 text-gray-400 text-sm">
            <p>Keep track of your favorite entertainment</p>
            </div>
        </div>
    </div>

</x-app-layout>
