<?php

namespace App\Http\Controllers;

use App\Models\ProfileSettings;
use App\Models\SiteStats;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileSettingsController extends Controller
{

    public function index()
    {
        return $data = ProfileSettings::where('user_id', Auth::id())
        ->latest()
        ->first();
    }


    public function getStats()
    {
        return $data = SiteStats::orderBy('created_at', 'DESC')->get();
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'about' => 'nullable|string',
            'nav_description' => 'nullable|string',
            'home_description' => 'nullable|string',
            'links' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('profile', 'public');
            $validated['picture'] = $path;
        };

//        dd( $request->links );
        if ($request->filled('links')) {
            $validated['links'] = json_decode($request->links, true);
        }

        $validated['user_id'] = Auth::id();



        ProfileSettings::create($validated);
        return back()->with('success', 'Profile saved');
    }


    public function update(Request $request)
    {
        $validated = $request->validate([
            'username'         => 'required|string|max:100',
            'occupation'       => 'nullable|string|max:150',
            'about'            => 'nullable|string',
            'nav_description'  => 'nullable|string|max:255',
            'home_description' => 'nullable|string|max:255',
            'links'            => 'nullable|string',
            'picture'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        $user = Auth::user();
        $profile = $user->profileSetting;

        if ($request->hasFile('picture')) {

            if ($profile->picture) {
                Storage::disk('public')->delete($profile->picture);
            }

            $validated['picture'] = $request->file('picture')->store('profiles', 'public');
        }

        $validated['links'] = json_decode($validated['links'] ?? '[]', true) ?? [];

        $profile->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'data' => $profile->fresh(),
        ]);
    }


    public function storeStats(Request $request)
    {
        $validated = $request->validate([
            'stats' => 'required|array',
            'stats.*.value'  => 'required|string|max:50',
            'stats.*.suffix' => 'nullable|string|max:20',
            'stats.*.label'  => 'required|string|max:100',
        ]);

        foreach ($validated['stats'] as $stat) {

            SiteStats::create([
                'value'  => $stat['value'],
                'suffix' => $stat['suffix'] ?? null,
                'label'  => $stat['label'],
            ]);

        }

        return response()->json([
            'message' => 'Stats saved',
        ]);
    }


}
