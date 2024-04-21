<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required'],
            'description' => ['required', 'max:10000']
        ]);
        $slug = Str::slug($request->title);
        $uniqueSlug = $slug;
        $count = 1;

        while (Post::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $slug . '-' . $count++;
        }
        $post = Post::create([
            'category_id' => $request->category_id,
            'author_id' => auth()->user()->id,
            'title' => $request->title,
            'slug' => $uniqueSlug,
            'content' => $request->description,
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'New Post Added',
            'data' => $post,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required'],
            'description' => ['required', 'max:10000']
        ]);
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'status' => 500,
                'message' => 'Post not found',
            ]);
        }

        if (!$this->isOwner($post->author_id)) {
            return response()->json([
                'status' => 500,
                'message' => 'You are not the owner of the post',
            ]);
        }

        $post->update([
            'category_id' => $request->category_id,
            'author_id' => auth()->user()->id,
            'title' => $request->title,
            'slug' => $post->slug,
            'content' => $request->description,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Post Updated Successfully',
            'data' => $post,
        ]);
    }


    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'status' => 500,
                'message' => 'Post not found'
            ]);
        }

        if (!$this->isOwner($post->author_id)) {
            return response()->json([
                'status' => 500,
                'message' => 'You are not the owner of the post'
            ]);
        }

        $post->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Post Deleted Successfully'
        ]);
    }


    private function isOwner($creator_id)
    {
        return $creator_id == auth()->id() || auth()->user()->hasRole('admin');
    }
}
