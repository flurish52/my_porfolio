<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return $data = Project::orderBy('created_at', 'DESC')
            ->with('skills')
            ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "required|string|max:255",
            "description" => "required|string",
            "skill_ids" => "array",
            "skill_ids.*" => "exists:skills,id"
        ]);

        $project = Project::create([
            "title" => $validated["title"],
            "description" => $validated["description"]
        ]);

        if (!empty($validated["skill_ids"])) {
            $project->skills()->sync($validated["skill_ids"]);
        }

        return response()->json([
            "message" => "Project created successfully",
        ]);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "title" => "required|string|max:255",
            "description" => "required|string",
            "skill_ids" => "array",
            "skill_ids.*" => "exists:skills,id"
        ]);

        $project = Project::findOrFail($id);

        $project->update([
            "title" => $validated["title"],
            "description" => $validated["description"]
        ]);

        if (isset($validated["skill_ids"])) {
            $project->skills()->sync($validated["skill_ids"]);
        }

        return response()->json([
            "message" => "Project updated successfully",
            "data" => $project->load("skills")
        ]);
    }


    public function destroy(Request $request, $id)
    {
        if (!$request->user()) {
            return response()->json([
                "message" => "Unauthenticated"
            ], 401);
        }

        $project = Project::findOrFail($id);

        $project->skills()->detach();

        $project->delete();

        return response()->json([
            "message" => "Project deleted successfully"
        ]);
    }



}
