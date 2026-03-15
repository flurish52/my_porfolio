<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    //

    public function index()
    {
        return $data =  Categories::orderBy('created_at', 'DESC')->get();
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new Categories();
        $category->name = $validated['name'];
        $category->save();

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Find record
        $category = Categories::findOrFail($id);

        // Update and save
        $category->name = $validated['name'];
        $category->save();

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }



    public function destroy(Request $request, $id)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Find the category or fail
        $category = Categories::findOrFail($id);

        // Delete it
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }

}
