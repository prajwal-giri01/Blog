<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class HomeController extends Controller
{
    public function search(Request $request)
    {
//        $posts = QueryBuilder::for(Post::class)
//            ->allowedFilters(['title', 'content'])
//            ->get();
        $search = $request->search;
        $posts = Post::where(function ($query) use ($search) {
            $query->where('title', 'like', "%$search%")
                ->orwhere('content', 'like', "%$search%");

        })
            ->orWhereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->orWhereHas('category', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->orWhereHas('taggables.tags', function ($query) use ($search) {
                $query->where('tags', 'like', "%$search%");
            })
            ->get();
        return response()->json([
            'status' => 200,
            'message' => 'fetching posts',
            'data' => $posts
        ]);


    }


}
