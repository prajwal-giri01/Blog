<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $post_id)
    {
        $request->vaildate([
           'comment' => ['required', 'max:5000']
        ]);

        $comment = Comment::create([
           'commentable_id' => $post_id,
            'commentable_type' => 'App\Post',
            'creator_id' => auth()->user()->id,
            'comment' => $request->comment
        ]);
        return response()->json([
           'status' => 200,
           'message' => 'comment has been created',
           'data' => $comment
        ]);
    }
}
