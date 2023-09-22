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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $any = '')
    {                                
        $request->merge(
            Generic::stringToArrayAssociative($any)
        );        
        
        $posts = new PostRepository(new Post());                
        $posts = $posts->filterBy($request->all());
        $posts = $posts->with('user')->paginate(10);        

        return Inertia::render('Home', [
            'response' => $posts
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {                        
        if(!$post = Post::where('slug', $slug)->first()) return abort(404);        
        $post->related();
        $post->like();
        
        return Inertia::render('Post/Show', [
            'post' => $post
        ]);        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Post/Form', [
            'category' => Category::get(),
            'method' => 'post'                       
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $request->validate([
            'title' => "required|string|max:500",
            'content' => "required|string",
            'category' => "required|exists:categories.id",
            'thumb' => "required|image"
        ]);

        $post = new Post();
        $post->user = auth()->user()->id;
        $post->title = $request->input("title");
        $post->content = $request->input("content");        
        $post->thumb = $request->file('thumb')->store('posts/thumb');
        $post->save();
        
        Logs::create(Post::class, "Create new post");
        return to_route('post.show', ['slug', $post->slug]);
    }    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return Inertia::render('Post/Form', [
            'post' => $post,
            'category' => Category::get(),            
            'method' => 'put'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title' => "required|string|max:500",
            'content' => "required|string",
            'category' => "required|exists:categories.id",
            'thumb' => 'image'
        ]);
        
        if($validator->fails()) {
            return ApiResponse::unprocessableEntity(
                $validator->errors()
            );
        }                        
        $data = $request->only(['title', 'content', 'category']);
        if($request->hasFile('thumb')) {
            if(Storage::exists($post->thumb)) {
                Storage::delete($post->thumb);
            } 
            $data['thumb'] = $request->file('thumb')->store('posts/thumb');
        }
        $post->fill($data)->save();

        Logs::update(Post::class, "Updated the id: $post->id post");
        return ApiResponse::success("Successfully updated post");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {        
        $payload = [
            'id' => $post->id,
            'name' => $post->title
        ];
        Logs::delete("Deleted post: \n".json_encode($payload));

        if(Storage::exists($post->thumb)) {
            Storage::delete($post->thumb);
        }         
        $post->delete();

        return ApiResponse::noContent("Successfully updated post");
    }
}
