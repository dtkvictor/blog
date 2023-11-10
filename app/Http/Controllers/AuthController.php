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
            'password' => 'required|string'            
        ]);   
        
        if(Auth::attempt($data)) {
            return to_route('site.index');
        }        

        return back()->withErrors([
            'fail' => "Unable to log in, please check your data and try again"
        ]);        
    }    

    public function register(Request $request)
    {
        $data = $request->validate([
            'profile' => 'image',
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:8',
        ]);        

        if($request->hasFile('profile')) {
            $data['profile'] = $request->file('profile')->store('users/picture');
        }
        
        User::create($data);
        return to_route('login');
    }

    public function logout()
    {
        Auth::logout();        
        return to_route('site.index');
    }

    public function formLogin(Request $request)
    {        
        if(auth()->check()) return to_route('site.index');        
        return Inertia::render('Auth/Login');
    }    

    public function formRegister(Request $request)
    {        
        return Inertia::render('Auth/Register');
    }
}
