<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyLibraryController extends Controller
{
    public function index(){
        return view('myLists');
    }
}
