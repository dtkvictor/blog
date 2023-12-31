<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Repository\UserRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Http\Helpers\Generic;

class UserController extends Controller
{
    public function author()
    {
        $author = User::whereHas('post')->get();
        return new UserCollection($author);
    }

    public function index(string $any = '')
    {
        $filters = Generic::stringToArrayAssociative($any);

        if(!isset($filters['orderBy'])) {
            $filters['orderBy'] = 'created';
        }
        
        $users = new UserRepository(new User());
        $users = $users->filterBy($filters)
                       ->where('id', '!=', auth()->id())
                       ->withCount(['post'])            
                       ->paginate(10)
                       ->onEachSide(1);
        
        $users->each(function($user) {
            $user->setUrlPicture();
        });
            
        return Inertia::render('User/Index', [
            'response' => $users,
        ]);
    }

    public function show(int $id)
    {
        $user = User::find($id);
        $posts = $user->post()->paginate(10)->onEachSide(1);        

        return Inertia::render('User/Show', [
            'user' => $user,
            'posts' => $posts
        ]);
    }
    
    public function update(Request $request, int $id)
    {
        if(!$user = User::find($id)) {
            return back()->withErrors([
                'erro' => 'User not found'
            ]);
        }       

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'admin' => 'required|boolean'
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->admin = $request->admin;
        
        $user->save();    
    }

    public function destroy(int $id) 
    {
        if(!$user = User::find($id)) {
            return back()->withErrors([
                'erro' => 'User not found'
            ]);
        }
        if(Storage::exists($user->picture)) { 
            Storage::delete($user->picture);
        }
        $user->delete();
    }
}
