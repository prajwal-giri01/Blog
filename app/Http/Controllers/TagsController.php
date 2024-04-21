<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tags;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tags' => ['required', 'unique:tags']
        ]);
        $tag = Tags::create([
            'tags' => $request->tags,
            'creator_id' => auth()->user()->id,
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Successfully created tags',
            'data' => $tag
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tags' => ['required', 'unique:tags']
        ]);

            $tag = Tags::find($id);
            if ($tag) {
                $tag->update([
                    'tags' => $request->tags,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Successfully updated tags',
                    'data' => $tag
                ]);
            }

        return response()->json([
            'status' => 500,
            'message' => 'Some Error has occurred',
        ]);
    }

    public function destroy($id)
    {

            $tag = Tags::find($id);
            if ($tag) {
                $tag->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Successfully deleted tag',
                    'data' => $tag
                ]);
            }

        return response()->json([
            'status' => 500,
            'message' => 'Some Error has occurred'
        ]);
    }

}
