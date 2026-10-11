<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Resume;
use App\Models\Setting;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Display the portfolio home page with hero, about, skills, and featured projects.
     */
    public function index()
    {
        $featuredProjects = Project::featured()->ordered()->take(3)->get();

        $stats = [
            'projects_count' => Project::count() ?: 3,
            'years_experience' => 2,
            'satisfied_clients' => 10,
            'commits_count' => 500,
        ];

        // Retrieve active skills dynamically from DB, cached for performance
        $skills = Cache::rememberForever('portfolio_public_skills', function () {
            $allSkills = Skill::active()->ordered()->get();
            
            // Group by category if any category is present, otherwise group as 'General'
            return $allSkills->groupBy(function ($skill) {
                return $skill->category ?: 'General';
            });
        });

        // Retrieve dynamic settings
        $designation = Setting::get('designation', 'PHP & Laravel Developer');
        $profileImage = Setting::get('profile_image');
        $activeResume = Resume::active();

        return view('pages.home', compact('featuredProjects', 'stats', 'skills', 'designation', 'profileImage', 'activeResume'));
    }
}
