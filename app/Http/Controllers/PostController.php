<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Helpers\Logs;
use Inertia\Inertia;
use App\Http\Repository\PostRepository;
use App\Models\Category;
use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Helpers\Generic;

class PostController extends Controller
{    
    public function my(Request $request, $any = '')
    {
        $filters = Generic::stringToArrayAssociative($any);

        if(!isset($filters['orderBy'])) {
            $filters['orderBy'] = 'created';
        }    
        $posts = new PostRepository(new Post());                
        $posts = $posts->filterBy($filters)
                       ->where('user', auth()->id())
                       ->with('user', 'category')
                       ->paginate(10)
                       ->onEachSide(1)
                       ->withQueryString();

        $posts->each(function($post) {
            $post->setUrlThumb();
        });
                        
        return Inertia::render('Post/My', [
            'response' => $posts
        ]);        
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $any = '')
    {                                           
        $filters = Generic::stringToArrayAssociative($any);

        if(!isset($filters['orderBy'])) {
            $filters['orderBy'] = 'created';
        }

        $posts = new PostRepository(new Post());
        $posts = $posts->filterBy($request->all());
        $posts = $posts->orderBy('updated_at', 'desc')
                        ->withCount('likes')                        
                        ->paginate(10)
                        ->onEachSide(1);
        
        $posts->each(function($post) {        
            $post->user = $post->user()->first();
            $post->category = $post->category()->first();
            $post->preview();
            $post->setUrlThumb();
        });

        return Inertia::render('Post/Index', [
            'response' => $posts,            
        ]);
    }    

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {                        
        if(!$post = Post::where('slug', $slug)->first()) return abort(404);

        $post->category = $post->category()->first();
        $post->user = $post->user()->first();
        $post->like();

        $comments = $post->comments()
                         ->orderBy('created_at', 'DESC')
                         ->limit(5)
                         ->get();

        $related = $post->related();
        
        return Inertia::render('Post/Show', [
            'post' => $post,
            'comments' => $comments,
            'related' => $related
        ]);        
    }    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $data = $request->validate([
            'title' => "required|string|max:500",
            'content' => "required|string",
            'category' => "required|exists:App\Models\Category,id",
            'thumb' => "required|image"
        ]);

        $data['user'] = auth()->id();
        $data['thumb'] = $request->file('thumb')->store('posts/thumb');        
        
        Post::create($data);
        Logs::create(Post::class, "Create new post");        
    }        

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $post)
    {                                
        if(!$post = Post::find($post)) {
            return back()->withErrors(['erro' => 'Post not found']);
        }

        if($post->user != auth()->user()->id) {
            return back()->withErrors(['erro' => 'You do not have permission to update this post']);
        }        

        $data = $request->validate([
            'title' => "required|string|max:500",
            'content' => "required|string",
            'category' => "required|exists:App\Models\Category,id",
            'thumb' => 'image|nullable'
        ]);                    

        if($request->hasFile('thumb')) {
            if(Storage::exists($post->thumb)) {
                Storage::delete($post->thumb);
            }
            $data['thumb'] = $request->file('thumb')->store('posts/thumb');            
        }else {
            $data['thumb'] = $post->thumb;
        }    

        $post->fill($data)->save();
        Logs::update(Post::class, "Updated the id: $post->id post");        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $post)
    {        
        if(!$post = Post::find($post)) {
            return back()->withErrors(['erro' => 'Post not found']);
        }

        if($post->user != auth()->id()) {
            return back()->withErrors([
                'erro' => 'You do not have permission to delete this post.'
            ]);
        }        
        
        $payload = [
            'id' => $post->id,
            'name' => $post->title
        ];

        Logs::delete("Deleted post: \n".json_encode($payload));

        if(Storage::exists($post->thumb)) {
            Storage::delete($post->thumb);
        }         

        $post->delete();
    }
}
