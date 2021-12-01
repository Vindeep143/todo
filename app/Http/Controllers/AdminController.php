<?php

namespace App\Http\Controllers;

use App\Models\Note;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAllNotes($id) {
        return response()->json(Note::where('user_id', $id)->get(), 200);
    }
}
