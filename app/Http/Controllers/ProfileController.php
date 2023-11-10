<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\CheckEmail;
use App\Rules\ComparePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show()
    {
        return Inertia::render('Profile/Show');
    }

    public function updateData(Request $request)
    {        
        $user = auth()->user();
        $data = $request->validate([
            'picture' => 'image|nullable',
            'email' => ['required','email', new CheckEmail()],
            'name' => 'required|string|max:255',
        ]);

        if($request->hasFile('picture')) {
            if(Storage::exists($user->picture)) {
                Storage::delete($user->picture);
            }       
            $data['picture'] = $request->file('picture')->store('users/picture');            
        }else {
            $data['picture'] = $user->picture;
        }

        $user->fill($data)->save();
    }

    public function updatePassword(Request $request)
    {                               
        $request->validate([
            'current_password' => ['required', 'string', 'min:8', 'max:255', new ComparePassword()],
            'password' => 'required|string|confirmed|min:8|max:255',            
        ]);
        $user = auth()->user();
        $user->password = $request->input('password');
        $user->save();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'max:255', new ComparePassword()],
        ]);
        $user = auth()->user();
        if(Storage::exists($user->picture)) { 
            Storage::delete($user->picture);
        }
        $user->delete();
        return to_route('post.index');
    }
}
