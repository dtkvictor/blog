<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;

class DashboardController extends Controller
{    
    public function index() 
    {
        $posts = Post::where('user', auth()->user()->id)->paginate(10);        
        return Inertia::render('Dashboard/Index', [            
            'posts' => $posts
        ]);
    }

}
