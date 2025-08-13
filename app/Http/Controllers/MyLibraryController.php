<?php

namespace App\Http\Controllers;
use App\Models\Anime;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class MyLibraryController extends Controller
{
    public function index(){

        //anime
        $watched_anime = Anime::whereHas('users', function($query) {
            $query->where('user_id', Auth::id());
        })->get();

        $wishlisted_anime = Anime::whereHas('wishlist', function($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return view('myLists',[
            'watched_anime' => $watched_anime,
            'wishlisted_anime' => $wishlisted_anime
        ]);
    }
}
