<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;

class UserController extends Controller
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

    public function create(Request $request)
    {
        $body = $request->json();
        $username = $body->get("username");
        if (User::where('username', $username )->exists()) {
            return response()->json(['status' => 'User '.$username.' already exists'],409);
        }
        $user = new User($body->all());
        $user->password = Hash::make($body->get("password"));
        $user->save();

        return response()->json($user, 201);
    }

    public function authenticate(Request $request) {
        $body = $request->json();
        try {
            $user = User::where('username', $body->get('username'))->firstOrFail();
        } catch(ModelNotFoundException $e)
          {
              return response()->json(['status' => 'Failed to authenticate'],401);
          }

        if (Hash::check($body->get('password'), $user->password)){
              $apitoken = base64_encode(Str::random(32));
              User::where('username', $body->get('username'))->update(['api_token' => "$apitoken"]);;
              return response()->json(['status' => 'Authentication Successful','api_token' => $apitoken], 200);
          } else {
              return response()->json(['status' => 'Failed to authenticate'],401);
          }
    }
}
