<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ContactMeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProfileSettingsController;
use App\Models\ProfileSettings;
use App\Models\SiteStats;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'profileProp' => ProfileSettings::first(),
        'statsProp' => SiteStats::orderBy('created_at', 'DESC')->get(),
        'projectsProp' => \App\Models\Project::orderBy('created_at', 'DESC')->with('skills')->get(),
        'categoryProp' => \App\Models\Categories::orderBy('created_at', 'DESC')->with('skills')->get(),
        'skillsProp' => \App\Models\Skill::orderBy('created_at', 'DESC')->get(),


        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::post('/contact-me', [ContactMeController::class, 'store']);
Route::get('/profile/settings', [ProfileSettingsController::class, 'index'])
    ->name('profile.settings.get');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'profileProp' => ProfileSettings::where('user_id', Auth::id()),
        'contactMessages' => \App\Models\ContactMe::orderBy('created_at', 'DESC')->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::post('/categories', [CategoriesController::class, 'store'])->name('category.store');
    Route::get('/categories', [CategoriesController::class, 'index'])->name('category.get');
    Route::delete('/categories/{category}', [CategoriesController::class, 'destroy'])->name('category.destroy');
    Route::put('/categories/{category}', [CategoriesController::class, 'update'])->name('category.update');    Route::post('/categories', [CategoriesController::class, 'store'])->name('category.store');


    Route::post('/skill', [SkillController::class, 'store'])->name('skill.store');
    Route::get('/skills', [SkillController::class, 'index'])->name('skill.get');
    Route::delete('/skill/{skill}', [SkillController::class, 'destroy'])->name('skill.destroy');
    Route::put('/skill/{skill}', [SkillController::class, 'update'])->name('skill.update');


    Route::post('/project', [ProjectController::class, 'store'])->name('Project.store');
    Route::get('/projects', [ProjectController::class, 'index'])->name('Project.get');
    Route::delete('/project/{project}', [ProjectController::class, 'destroy'])->name('Project.destroy');
    Route::put('/project/{project}', [ProjectController::class, 'update'])->name('Project.update');


    Route::post('/profile/settings', [ProfileSettingsController::class, 'store'])->name('profile.settings.store');
//    Route::get('/profile/settings', [ProfileSettingsController::class, 'index'])->name('profile.settings.get');
    Route::put('/profile/settings', [ProfileSettingsController::class, 'update'])->name('profile.settings.update');


    Route::post('/site-stats', [ProfileSettingsController::class, 'storeStats'])->name('profile.stats.store');
    Route::get('/site-stats', [ProfileSettingsController::class, 'getStats'])->name('profile.stats.store');


    Route::delete('/contact-me/{contactMe}', [ContactMeController::class, 'destroy'])->name('contact.destroy');
});

require __DIR__.'/auth.php';
