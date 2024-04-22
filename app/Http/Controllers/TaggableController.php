<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Taggable;
use Illuminate\Http\Request;

class TaggableController extends Controller
{
    public function store(Request $request, $post_id)
    {
        $request->validate([
            'tag_id' => ['required', 'exists:tags,id']
        ]);
        $post = Post::find($post_id);
        if (!$post) {
            return response()->json([
                'status' => 500,
                'message' => 'Some error has occurred'
            ]);
        }
        $taggable = Taggable::create([
            'tag_id' => $request->tag_id,
            'taggable_id' => $post_id,
            'taggable_type' => 'App\Models\Post'
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'taggable created successfully',
            'data' => $taggable,
        ]);
    }

    public function update(Request $request, $id, $post_id)
    {
        $request->validate([
            'tag_id' => ['required', 'exists:tags,id']
        ]);
        $post = Post::find($post_id);
        $taggable = Taggable::find($id);
        if (!$post || !$taggable) {
            return response()->json([
                'status' => 500,
                'message' => 'some error has occurred',
            ]);
        }
        if (!$this->isOwner($post->author_id)) {
            return response()->json([
                'status' => 500,
                'message' => 'unauthorized activity'
            ]);
        }
        $taggable->update([
            'tag_id' => $request->tag_id,
            'taggable_id' => $post_id,
            'taggable_type' => 'App\Models\\Post'
        ]);
        return response()->json([
           'status'=>200,
           'message' => 'taggable updated successfully',
           'data' => $taggable
        ]);


    }

    public function destroy($id, $post_id)
    {
        $post = Post::find($post_id);
        $taggable = Taggable::find($id);
        if (!($post || $taggable)) {
            return response()->json([
                'status' => 500,
                'message' => 'some error has occurred',
            ]);
        }
        if (!$this->isOwner($post->author_id)) {
            return response()->json([
                'status' => 500,
                'message' => 'unauthorized activity'
            ]);
        }
        $taggable->delete();
        return response()->json([
           'status' => 200,
           'message' => 'taggable deleted successfully'
        ]);

    }

    private function isOwner($postOwner_id)
    {
        return auth()->user()->hasRole('admin') || $postOwner_id == auth()->id();
    }
}
