<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{

    public function index(\Illuminate\Http\Request $request)
    {
        return !app()->environment('testing')
            ? view('welcome')
            : response()->json();
    }
}
