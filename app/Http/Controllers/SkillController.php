<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{


    public function index(){
       return $data = Skill::with('categories')->
        orderBy('created_at', 'DESC')
            ->get();
    }

    public function store(Request $request)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_ids' => 'array'
        ]);

        $skill = Skill::create([
            'name' => $validated['name']
        ]);

        if (!empty($validated['category_ids'])) {
            $skill->categories()->sync($validated['category_ids']);
        }

        return response()->json([
            'message' => 'Skill created successfully',
            'data' => $skill
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_ids' => 'array'
        ]);

        $skill = Skill::findOrFail($id);

        $skill->update([
            'name' => $validated['name']
        ]);

        if (isset($validated['category_ids'])) {
            $skill->categories()->sync($validated['category_ids']);
        }

        return response()->json([
            'message' => 'Skill updated successfully',
            'data' => $skill->load('categories')
        ]);
    }



    public function destroy($id)
    {

        if (!Auth::id()) {
            return response()->json([
                "message" => "Unauthenticated"
            ], 401);
        }

        $skill = Skill::findOrFail($id);

        $skill->categories()->detach();

        $skill->delete();

        return response()->json([
            'message' => 'Skill deleted successfully'
        ]);
    }

}
