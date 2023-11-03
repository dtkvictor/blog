<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        return Inertia::render('Profile/Show');
    }

    public function updateData(Request $request)
    {
        $request->validate([
            'profile' => 'image',
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
        ]);
        
        $user = User::find(auth()->user()->id);
        $data = $request->only(['email', 'name']);
        
        if($request->hasFile('profile')) {            
            $data['profile'] = $request->file('picture')->store('');
        }

        $user->fill($data)->save();
    }

    public function updatePassword(Request $request)
    {                               
        $request->validate([
            'current_password' => ['required', 'string', 'min:8', 'max:255', new ComparePassword()],
            'password' => 'required|string|confirmed|min:8|max:255',            
        ]);

        $user = User::find(auth()->user()->id);   
        $user->password = $request->input('password');
        $user->save();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'max:255', new ComparePassword()],
        ]);

        $user = User::find(auth()->user()->id);

        if(Storage::exists($user->picture)) { 
            Storage::delete($user->picture);
        }

        $user->delete();
        return to_route('post.index');
    }
}
