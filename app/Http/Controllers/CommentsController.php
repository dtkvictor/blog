<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Resources\CommentsCollection;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{      
    public function index($post)
    {                        
        $comments = Comments::where('post', $post)->orderBy('created_at', 'DESC')->paginate(4);
        return new CommentsCollection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'post' => 'required|exists:posts,id',
            'text' => 'required|string'
        ]);                
        $data['user'] = auth()->id();
        Comments::create($data);        
    }    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $user = auth()->id();

        $request->validate([            
            'text' => 'required|string'
        ]);        

        if(!$comment = Comments::where('user', $user)->find($id)) {
            return back()->withErrors(["erro" => "Comment not found"]);        
        }                        

        $comment->text = $request->input('text');
        $comment->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $user = auth()->user();

        if($user->admin && $comment = Comments::find($id)) {
            $comment->delete();
        }
        else if($comment = Comments::where('user', $user->id)->find($id)) {
            $comment->delete();            
        }
        else {
            return back()->withErrors(["erro" => "Comment not found"]);
        }
    }
}
