<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of all projects with category filters.
     */
    public function index(Request $request)
    {
        $query = Project::ordered();

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $projects = $query->get();
        $categories = Project::select('category')->distinct()->pluck('category');

        return view('pages.projects', compact('projects', 'categories'));
    }

    /**
     * Display the specified project or return JSON for glass modal preview.
     */
    public function show(Request $request, string $slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'data' => $project,
            ]);
        }

        $relatedProjects = Project::where('id', '!=', $project->id)
            ->ordered()
            ->take(2)
            ->get();

        return view('pages.project-detail', compact('project', 'relatedProjects'));
    }
}
