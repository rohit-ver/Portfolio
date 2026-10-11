<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceAdminController extends Controller
{
    public function index()
    {
        $experiences = Experience::ordered()->get();
        return view('admin.experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('admin.experiences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'type' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'nullable|boolean',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|string', // newline separated
            'tech_stack' => 'nullable|string', // comma separated
            'sort_order' => 'nullable|integer',
        ]);

        $responsibilitiesArray = null;
        if (!empty($validated['responsibilities'])) {
            $responsibilitiesArray = array_values(array_filter(array_map('trim', explode("\n", $validated['responsibilities']))));
        }

        $techArray = null;
        if (!empty($validated['tech_stack'])) {
            $techArray = array_values(array_filter(array_map('trim', explode(',', $validated['tech_stack']))));
        }

        Experience::create([
            'company' => $validated['company'],
            'designation' => $validated['designation'],
            'location' => $validated['location'],
            'type' => $validated['type'],
            'start_date' => $validated['start_date'],
            'end_date' => $request->boolean('is_current') ? null : $validated['end_date'],
            'is_current' => $request->boolean('is_current'),
            'description' => $validated['description'],
            'responsibilities' => $responsibilitiesArray,
            'tech_stack' => $techArray,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.experiences.index')->with('success', 'Experience created successfully.');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'type' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'nullable|boolean',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'tech_stack' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $responsibilitiesArray = null;
        if (!empty($validated['responsibilities'])) {
            $responsibilitiesArray = array_values(array_filter(array_map('trim', explode("\n", $validated['responsibilities']))));
        }

        $techArray = null;
        if (!empty($validated['tech_stack'])) {
            $techArray = array_values(array_filter(array_map('trim', explode(',', $validated['tech_stack']))));
        }

        $experience->update([
            'company' => $validated['company'],
            'designation' => $validated['designation'],
            'location' => $validated['location'],
            'type' => $validated['type'],
            'start_date' => $validated['start_date'],
            'end_date' => $request->boolean('is_current') ? null : $validated['end_date'],
            'is_current' => $request->boolean('is_current'),
            'description' => $validated['description'],
            'responsibilities' => $responsibilitiesArray,
            'tech_stack' => $techArray,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.experiences.index')->with('success', 'Experience updated successfully.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return redirect()->route('admin.experiences.index')->with('success', 'Experience deleted successfully.');
    }
}
