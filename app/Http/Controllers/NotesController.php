<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Auth;

class NotesController extends Controller
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


    public function create(Request $request)
    {
        $user = Auth::user();
        $body = $request->json();
        $note = new Note($body->all());
        $note->user_id = $user['id'];
        $note->save();

        return response()->json($note, 201);
    }

    public function getNoteById($id) {
        $user = Auth::user();
        try{
            $note = Note::findOrFail($id);
        } catch(ModelNotFoundException $e){
              return response()->json(['status' => 'Note Id '.$id.' not found'],404);
          }
        if($note['user_id'] == $user['id']) {
            return response()->json(Note::find($id));
        }
        $username = $user['username'];
        $noteId = $note['id'];
        return response()->json(['status' => 'User : '.$username.' is not authorized to view note id : '.$noteId], 401);
    }

    public function setCompleted($id) {
        $user = Auth::user();
        try{
            $note = Note::findOrFail($id);
        } catch(ModelNotFoundException $e)
          {
              return response()->json(['status' => 'Note Id '.$id.' not found'],404);
          }
        if($note['user_id'] == $user['id']) {
            $noteId = $note['id'];
            if ($note['isCompleted'] == 1) {
                $timestamp = $note['completedAt'];
                return response()->json(['status' => 'Note Id : '.$noteId.' is already marked as completed on '.$timestamp], 400);
            } else {
                $timestamp = Carbon::now();
                $note->update(['isCompleted' => 1, 'completedAt' => $timestamp]);
                return response()->json($note, 200);
            }
        }
        $username = $user['username'];
        $noteId = $note['id'];
        return response()->json(['status' => 'User : '.$username.' is not authorized to view note id : '.$noteId], 401);
    }

    public function setIncomplete($id) {
        $user = Auth::user();
        try{
            $note = Note::findOrFail($id);
        } catch(ModelNotFoundException $e)
          {
              return response()->json(['status' => 'Note Id '.$id.' not found'],404);
          }
        if($note['user_id'] == $user['id']) {
            $noteId = $note['id'];
            if ($note['isCompleted'] == 0) {
                return response()->json(['status' => 'Note Id : '.$noteId.' is already marked as Incomplete'], 401);
            } else {
                $timestamp = NULL;
                $note->update(['isCompleted' => 0, 'completedAt' => $timestamp]);
                return response()->json($note, 200);
            }
        }
        $username = $user['username'];
        $noteId = $note['id'];
        return response()->json(['status' => 'User : '.$username.' is not authorized to view note id : '.$noteId], 401);
    }

    public function getAllNotesForUser() {
        $user = Auth::user();
        $userId = $user['id'];
        return response()->json(Note::where('user_id', $userId)->get(), 200);
    }

    public function deleteNoteById($id)
    {
        $user = Auth::user();
        try{
            $note = Note::findOrFail($id);
        } catch(ModelNotFoundException $e)
          {
              return response()->json(['status' => 'Note Id '.$id.' not found'],404);
          }
        if($note['user_id'] == $user['id']) {
            Note::findOrFail($id)->delete();
                    return response()->json(['status' => 'Note id '.$id.' Deleted Successfully'], 201);
        }
        $username = $user['username'];
        $noteId = $note['id'];
        return response()->json(['status' => 'User : '.$username.' is not authorized to delete note id : '.$noteId], 401);
    }
}
