<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    /**
     * Download the latest active resume.
     */
    public function download()
    {
        $resume = Resume::active();

        if (!$resume || !Storage::disk('public')->exists($resume->file_path)) {
            return redirect()->back()->with('error', 'The resume file is currently being updated. Please check back shortly or contact me directly.');
        }

        // Increment download counter
        $resume->increment('download_count');

        $downloadFilename = 'Rohit_Verma_Resume.pdf';
        return Storage::disk('public')->download($resume->file_path, $downloadFilename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
