<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResumeAdminController extends Controller
{
    public function index()
    {
        $resumes = Resume::latest()->get();
        $activeResume = Resume::active();
        return view('admin.resume.index', compact('resumes', 'activeResume'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'resume_file' => 'required|file|mimes:pdf|max:5120', // Max 5MB, PDF only
        ]);

        $file = $request->file('resume_file');
        $originalName = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        // Safe random filename inside storage/app/public/resume
        $randomFilename = 'resume_' . time() . '_' . Str::random(12) . '.pdf';
        $storedPath = $file->storeAs('resume', $randomFilename, 'public');

        // Deactivate previous active resumes
        Resume::where('is_active', true)->update(['is_active' => false]);

        Resume::create([
            'original_name' => $originalName,
            'file_path' => $storedPath,
            'file_size' => $fileSize,
            'is_active' => true,
            'download_count' => 0,
        ]);

        return redirect()->route('admin.resume.index')->with('success', 'Resume PDF uploaded and set as active successfully.');
    }

    public function setActive(Resume $resume)
    {
        Resume::where('id', '!=', $resume->id)->update(['is_active' => false]);
        $resume->update(['is_active' => true]);

        return redirect()->route('admin.resume.index')->with('success', 'Active resume updated.');
    }

    public function destroy(Resume $resume)
    {
        if (Storage::disk('public')->exists($resume->file_path)) {
            Storage::disk('public')->delete($resume->file_path);
        }

        $resume->delete();

        // If deleted was active, activate latest remaining if any
        if ($resume->is_active) {
            $latest = Resume::latest()->first();
            if ($latest) {
                $latest->update(['is_active' => true]);
            }
        }

        return redirect()->route('admin.resume.index')->with('success', 'Resume record and file removed.');
    }
}
