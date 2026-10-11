<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillRequest;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SkillAdminController extends Controller
{
    /**
     * Display a listing of skills with search and category filtering.
     */
    public function index(Request $request)
    {
        $query = Skill::ordered();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

        $skills = $query->get();
        $categories = Skill::whereNotNull('category')->distinct()->pluck('category');

        return view('admin.skills.index', compact('skills', 'categories'));
    }

    /**
     * Show the form for creating a new skill.
     */
    public function create()
    {
        $existingCategories = Skill::whereNotNull('category')->distinct()->pluck('category');
        return view('admin.skills.create', compact('existingCategories'));
    }

    /**
     * Store a newly created skill in storage.
     */
    public function store(SkillRequest $request)
    {
        $validated = $request->validated();

        $iconImagePath = null;
        if ($request->hasFile('icon_image_file')) {
            $file = $request->file('icon_image_file');
            $filename = 'skill_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            
            $destinationPath = public_path('uploads/skills');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $iconImagePath = 'uploads/skills/' . $filename;
        }

        Skill::create([
            'name' => $validated['name'],
            'category' => $validated['category'] ?? null,
            'icon_type' => $validated['icon_type'],
            'icon_class' => $validated['icon_type'] === 'class' ? $validated['icon_class'] : null,
            'icon_image' => $validated['icon_type'] === 'image' ? $iconImagePath : null,
            'proficiency' => $validated['proficiency'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->clearSkillsCache();

        return redirect()->route('admin.skills.index')->with('success', 'Skill created successfully.');
    }

    /**
     * Show the form for editing the specified skill.
     */
    public function edit(Skill $skill)
    {
        $existingCategories = Skill::whereNotNull('category')->distinct()->pluck('category');
        return view('admin.skills.edit', compact('skill', 'existingCategories'));
    }

    /**
     * Update the specified skill in storage.
     */
    public function update(SkillRequest $request, Skill $skill)
    {
        $validated = $request->validated();

        $data = [
            'name' => $validated['name'],
            'category' => $validated['category'] ?? null,
            'icon_type' => $validated['icon_type'],
            'icon_class' => $validated['icon_type'] === 'class' ? $validated['icon_class'] : null,
            'proficiency' => $validated['proficiency'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($validated['icon_type'] === 'image') {
            if ($request->hasFile('icon_image_file')) {
                // Delete old icon file if exists
                if ($skill->icon_image && file_exists(public_path($skill->icon_image))) {
                    @unlink(public_path($skill->icon_image));
                }

                $file = $request->file('icon_image_file');
                $filename = 'skill_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                
                $destinationPath = public_path('uploads/skills');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);
                $data['icon_image'] = 'uploads/skills/' . $filename;
            } else {
                // Retain existing image
                $data['icon_image'] = $skill->icon_image;
            }
        } else {
            // Icon type switched to class; unlink old image if existed
            if ($skill->icon_image && file_exists(public_path($skill->icon_image))) {
                @unlink(public_path($skill->icon_image));
            }
            $data['icon_image'] = null;
        }

        $skill->update($data);

        $this->clearSkillsCache();

        return redirect()->route('admin.skills.index')->with('success', 'Skill updated successfully.');
    }

    /**
     * Remove the specified skill from storage.
     */
    public function destroy(Skill $skill)
    {
        // Unlink icon image file if exists
        if ($skill->icon_image && file_exists(public_path($skill->icon_image))) {
            @unlink(public_path($skill->icon_image));
        }

        $skill->delete();

        $this->clearSkillsCache();

        return redirect()->route('admin.skills.index')->with('success', 'Skill deleted successfully.');
    }

    /**
     * Toggle the active state of a skill via AJAX.
     */
    public function toggle(Skill $skill)
    {
        $skill->update([
            'is_active' => !$skill->is_active,
        ]);

        $this->clearSkillsCache();

        return response()->json([
            'success' => true,
            'is_active' => $skill->is_active,
            'message' => 'Skill status updated successfully.',
        ]);
    }

    /**
     * Reorder skills via AJAX.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer'],
        ]);

        foreach ($request->input('order') as $position => $id) {
            Skill::where('id', $id)->update(['sort_order' => $position + 1]);
        }

        $this->clearSkillsCache();

        return response()->json([
            'success' => true,
            'message' => 'Skills reordered successfully.',
        ]);
    }

    /**
     * Clear skills cache helper.
     */
    protected function clearSkillsCache(): void
    {
        Cache::forget('portfolio_public_skills');
    }
}
