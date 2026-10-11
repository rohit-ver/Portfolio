<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    /**
     * Display the public Experience timeline page.
     */
    public function index()
    {
        $experiences = Experience::ordered()->get();
        return view('pages.experience', compact('experiences'));
    }
}
