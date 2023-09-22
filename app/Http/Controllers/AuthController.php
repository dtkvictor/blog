<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{        

    public function login(Request $request)
    {                        
        $data = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
            'remember'
        ]);        

        $user = User::where('email', $data['email'])
                    ->where('password', sha1($data['password']))
                    ->first();

        if($user) {
            Auth::login($user);
            return to_route('post.index');
        }                        

        $request->session()->put(
            'failsLogin', 
            "Unable to log in, please check your data and try again"
        );

        return to_route('login');        
    }    

    public function register(Request $request)
    {
        $rules = [
            'profile' => 'image',
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:8',
        ];
        
        User::create($request->validate($rules));    
        return to_route('login');
    }

    public function logout()
    {
        Auth::logout();        
        return to_route('post.index');
    }

    public function formLogin(Request $request)
    {        
        if(auth()->user()) return to_route('post.index');

        $fails = $request->session()->pull('failsLogin', '');
        return Inertia::render('Auth/Login', [
            'fails' => $fails
        ]);
    }    

    public function formRegister(Request $request)
    {
        $fails = $request->session()->pull('failsLogin', '');

        return Inertia::render('Auth/Register', [
            'fails' => $fails
        ]);
    }
}
