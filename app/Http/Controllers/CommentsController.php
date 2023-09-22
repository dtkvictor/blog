<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Resources\CommentsCollection;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{        

    public function show(int $post) 
    {
        $comments = Comments::where('post', $post)->orderBy('created_at', 'desc')->paginate(10);
        if($comments) return new CommentsCollection($comments);
        return ApiResponse::noContent("");
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post' => 'required|exists:posts,id',
            'text' => 'required|string'
        ], $request->all());

        if($validator->fails()) {
            return ApiResponse::unprocessableEntity(
                $validator->errors()
            );
        }

        $comment = new Comments();
        $comment->user = auth()->user()->id;
        $comment->post = $request->input('post');
        $comment->text = $request->input('text');
        $comment->save();
        
        return ApiResponse::created("Successfully created comment", $comment);
    }    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [            
            'text' => 'required|string'
        ], $request->all());

        if($validator->fails()) {
            return ApiResponse::unprocessableEntity(
                $validator->errors()
            );
        }        

        $user = auth()->user()->id;
        if(!$comment = Comments::where('user', $user)->find($id)) {
            return ApiResponse::notFound("Comment not found");
        }                        
        $comment->text = $request->input('text');
        $comment->save();

        return ApiResponse::success("Successfuly updated comment");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $user = auth()->user()->id;

        if(!$comment = Comments::where('user', $user)->find($id)) {
            return ApiResponse::notFound("Comment not found");
        }

        $comment->delete();
        return ApiResponse::noContent("Successfully deleted comment");
    }
}
