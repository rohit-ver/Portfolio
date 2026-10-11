<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectAdminController extends Controller
{
    public function index()
    {
        $projects = Project::ordered()->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'long_description' => 'nullable|string',
            'tech_stack' => 'required|string', // comma-separated
            'live_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $slug = $validated['slug'] ?: Str::slug($validated['title']);
        $techArray = array_values(array_filter(array_map('trim', explode(',', $validated['tech_stack']))));

        $imagePath = '/images/projects/placeholder.svg';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'project_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/projects'), $filename);
            $imagePath = 'uploads/projects/' . $filename;
        }

        Project::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'description' => $validated['description'],
            'long_description' => $validated['long_description'],
            'tech_stack' => $techArray,
            'image' => $imagePath,
            'live_url' => $validated['live_url'],
            'github_url' => $validated['github_url'],
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:projects,slug,' . $project->id,
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'long_description' => 'nullable|string',
            'tech_stack' => 'required|string',
            'live_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $techArray = array_values(array_filter(array_map('trim', explode(',', $validated['tech_stack']))));
        $data = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'category' => $validated['category'],
            'description' => $validated['description'],
            'long_description' => $validated['long_description'],
            'tech_stack' => $techArray,
            'live_url' => $validated['live_url'],
            'github_url' => $validated['github_url'],
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'project_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/projects'), $filename);
            $data['image'] = 'uploads/projects/' . $filename;
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
