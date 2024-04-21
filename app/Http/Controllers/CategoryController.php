<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:categories']
        ]);

        $category = Category::create([
            'creator_id' => auth()->user()->id,
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Successfully created category',
            'data' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'unique:categories,name']
        ]);

            $category = Category::find($id);
            if ($category) {
                $category->update([
                    'name' => $request->name,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Successfully updated category',
                    'data' => $category
                ]);
            }

        return response()->json([
            'status' => 500,
            'message' => 'Some Error has occurred'
        ]);
    }

    public function destroy($id)
    {
            $category = Category::find($id);
            if ($category) {
                $category->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Successfully deleted category',
                    'data' => $category
                ]);
            }

        return response()->json([
            'status' => 500,
            'message' => 'Some Error has occurred'
        ]);
    }

}
