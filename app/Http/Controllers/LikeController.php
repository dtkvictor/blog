<?php

namespace App\Http\Controllers;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $request->validate(['post' => 'int|exists:posts,id']);
        
        $user = auth()->id();
        $post = $request->post;

        if($like = Like::where('user', $user)->where('post', $post)->first()) {            
            $like->delete();
        } else {
            Like::create(['user' => $user, 'post' => $post]);        
        }                    
    }

}
