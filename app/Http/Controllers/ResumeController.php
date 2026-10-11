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

        // 1. Admin panel se upload hua resume (agar DB me hai aur file maujood hai)
        if ($resume && Storage::disk('public')->exists($resume->file_path)) {
            $resume->increment('download_count');

            return response()->download(Storage::disk('public')->path($resume->file_path), 'Rohit_Verma_Resume.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        }

        // 2. Fallback: git me rakha hua resume (public/files/resume.pdf)
        $fallback = public_path('files/resume.pdf');
        if (file_exists($fallback)) {
            return response()->download($fallback, 'Rohit_Verma_Resume.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        }

        return redirect()->back()->with('error', 'The resume file is currently being updated. Please check back shortly or contact me directly.');
    }
}
