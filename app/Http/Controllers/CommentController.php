<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($post_id)
    {
        $post = Post::find($post_id);
        if (!$post) {
            return response()->json([
                'status' => 500,
                'message' => 'Some error has occurred'
            ]);
        }
        $comments = Comment::where('commentable_id', $post_id)->paginate(10);

        if ($comments->isEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'No comments available',
                'data' => []
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Fetching comments',
                'data' => $comments
            ]);
        }

    }

    public function store(Request $request, $post_id)
    {
        $request->validate([
            'comment' => ['required', 'max:5000']
        ]);
        $post = Post::find($post_id);
        if (!$post) {
            return response()->json([
                'status' => 500,
                'message' => 'Some error has occurred'
            ]);
        }
        $comment = Comment::create([
            'commentable_id' => $post_id,
            'commentable_type' => 'App\Models\Post',
            'creator_id' => auth()->user()->id,
            'comment' => $request->comment
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'comment has been created',
            'data' => $comment
        ]);
    }

    public function update(Request $request, $id, $post_id)
    {
        $request->validate([
            'comment' => ['required', 'max:5000']
        ]);
        $post = Post::find($post_id);
        $comment = Comment::find($id);
        if (!$post || !$comment) {
            return response()->json([
                'status' => 500,
                'message' => 'Some error has occurred'
            ]);
        }
        if (!$this->isOwner($comment->creator_id, $post->author_id)) {
            return response()->json([
                'status' => 500,
                'message' => 'unauthorized activity'
            ]);
        }

        $comment->update([
            'commentable_id' => $post_id,
            'commentable_type' => 'App\Models\Post',
            'creator_id' => $comment->creator_id,
            'comment' => $request->comment
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'comment has been updated',
            'data' => $comment
        ]);
    }

    public function destroy($id, $post_id)
    {
        $post = Post::find($post_id);
        $comment = Comment::find($id);

        if (!$post || !$comment) {
            return response()->json([
                'status' => 500,
                'message' => 'Some error has occurred'
            ]);
        }
        if (!$this->isOwner($comment->creator_id, $post->author_id)) {
            return response()->json([
                'status' => 500,
                'message' => 'unauthorized activity'
            ]);
        }
        $comment->delete();
        return response()->json([
            'status' => 200,
            'message' => 'comment deleted successfully'
        ]);
    }

    private function isOwner($creator_id, $postOwner_id)
    {
        return $creator_id == auth()->id() || auth()->user()->hasRole('admin') || $postOwner_id == auth()->id();
    }
}
