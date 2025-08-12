<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MediaController;
use App\Models\Anime;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }
}
