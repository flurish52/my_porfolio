<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        return $data = Project::orderBy('position', 'DESC')
            ->with('skills')
            ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'role' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',

            'skill_ids' => 'nullable|array',
            'skill_ids.*' => 'exists:skills,id',

            'image' => 'nullable|image|max:1024' // 1MB
        ]);

        if (!empty($validated['link'])) {
            if (!preg_match('/^https?:\/\//i', $validated['link'])) {
                $validated['link'] = 'https://' . $validated['link'];
            }
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $validated['image'] = $path;
        }


        $project = Project::create([
            "title" => $validated["title"],
            "description" => $validated["description"],
            "role" => $validated["role"],
            "link" => $validated["link"],
            "image" => $validated["image"],
        ]);

        if (!empty($validated["skill_ids"])) {
            $project->skills()->sync($validated["skill_ids"]);
        }

        return response()->json([
            "message" => "Project created successfully",
        ]);
    }


    public function update(Request $request, $project)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'role'        => 'nullable|string|max:255',
            'link'        => 'nullable|string|max:255',

            'skill_ids'   => 'nullable|array',
            'skill_ids.*' => 'exists:skills,id',

            'image'       => 'nullable' // handle manually
        ]);

        // fix link
        if (!empty($validated['link'])) {
            if (!preg_match('/^https?:\/\//i', $validated['link'])) {
                $validated['link'] = 'https://' . $validated['link'];
            }
        }
        $project = Project::findOrFail($project);

        // handle image
        if ($request->hasFile('image')) {
            // delete old
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }

            // store new
            $path = $request->file('image')->store('projects', 'public');
            $validated['image'] = $path;

        } elseif ($request->input('image') === null) {
            // user removed image

            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }

            $validated['image'] = null;

        } else {
            // keep existing image
            unset($validated['image']);
            $validated['image'] = $project->image;
        }

//        dd($validated);

        $project->update([
            "title" => $validated["title"],
            "description" => $validated["description"],
            "role" => $validated["role"],
            "link" => $validated["link"],
            "image" => $validated["image"],
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
