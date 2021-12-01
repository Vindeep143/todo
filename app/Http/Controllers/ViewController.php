<?php

namespace App\Http\Controllers;

use Auth;

class ViewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function loadDashboard() {
        $user = Auth::user();
        return view('dashboard',['username' => $user['username']]);
    }

}
