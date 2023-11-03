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

        $user = User::where('email', $request->email)->first();                

        if(password_verify($request->password, $user->password)) {
            Auth::login($user);
            return to_route('site.index');
        }                        

        $request->session()->put(
            'failsLogin', 
            "Unable to log in, please check your data and try again"
        );

        return to_route('login');        
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
        if(auth()->user()) return to_route('site.index');

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
