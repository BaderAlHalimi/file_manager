<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    function index(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // echo $user->password;
        if (!$user) {
            abort(404);
        } else {
            if (Hash::check($request->password, $user->password)) {
                session()->put('user_id', $user->id);
                $request->session()->flash('login_success', 'login successfully');
                return redirect()->route('home');
            } else {
                abort(404);
            }
        }
    }
    function store(UserRequest $request)
    {
        $validated = $request->validated();
        User::create($validated);
        return redirect()->route('signup');
    }
}
