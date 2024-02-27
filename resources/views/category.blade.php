<section>
    @php
    $category = Route::current()->parameter('category');
    @endphp


    <h1>My {{$category}} library</h1>
    <ul>
        <li>add watched {{$category}} </li>
        <li>add to watch {{$category}} </li>
    </ul>

    <div class="list">
        <div class="flex">
            @component('components.media-card')
            @endcomponent
        </div>
    </div>
    <form method="GET" action="">
        <input type="text" placeholder="search.." name="search"> 
    </form>
</section>