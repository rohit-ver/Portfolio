<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Resume;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin overview dashboard.
     */
    public function index()
    {
        $metrics = [
            'projects' => Project::count(),
            'experiences' => Experience::count(),
            'messages' => Contact::count(),
            'unread_messages' => Contact::where('is_read', false)->count(),
            'resume_downloads' => Resume::sum('download_count'),
            'active_resume' => Resume::active(),
        ];

        $recentMessages = Contact::latest()->take(5)->get();
        $recentProjects = Project::ordered()->take(3)->get();

        return view('admin.dashboard', compact('metrics', 'recentMessages', 'recentProjects'));
    }
}
