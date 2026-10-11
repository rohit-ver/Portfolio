@extends('admin.layout')

@section('title', 'Resume Manager')
@section('page_title', 'Resume Manager')
@section('page_subtitle', 'Upload, replace, and track downloads of your CV / Resume')

@section('content')

<div class="row g-4 mb-4">
    <!-- Active Resume Card -->
    <div class="col-lg-5">
        <div class="glass p-4 h-100">
            <h5 class="font-heading mb-3">Current Active Resume</h5>

            @if($activeResume)
                <div class="p-3 rounded mb-3" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3);">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="bi bi-file-earmark-pdf-fill fs-1 text-danger"></i>
                        <div>
                            <strong class="d-block" style="color: var(--text-main); font-size: 1rem;">
                                {{ $activeResume->original_name }}
                            </strong>
                            <small class="text-muted">
                                {{ number_format($activeResume->file_size / 1024, 1) }} KB &bull; Uploaded {{ $activeResume->created_at->format('M d, Y') }}
                            </small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-2" style="border-top: 1px solid rgba(255,255,255,0.08);">
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle me-1"></i>Active on Site
                        </span>
                        <span class="text-muted" style="font-size: 0.85rem;">
                            <i class="bi bi-download me-1"></i>{{ $activeResume->download_count }} downloads
                        </span>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ Storage::url($activeResume->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info flex-grow-1">
                        <i class="bi bi-eye"></i> Preview PDF
                    </a>
                    <a href="{{ route('resume.download') }}" class="btn btn-sm btn-success flex-grow-1">
                        <i class="bi bi-download"></i> Test Download
                    </a>
                </div>
            @else
                <div class="p-4 text-center rounded mb-3" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);">
                    <i class="bi bi-exclamation-triangle-fill text-warning fs-1 mb-2 d-block"></i>
                    <h6>No Active Resume Uploaded</h6>
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">
                        The "Download Resume" button is currently hidden on the public site until you upload a PDF below.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Upload New Resume Form -->
    <div class="col-lg-7">
        <div class="glass p-4 h-100">
            <h5 class="font-heading mb-2">Upload or Replace Resume</h5>
            <p class="text-muted mb-3" style="font-size: 0.88rem;">
                Uploading a new PDF will automatically store it safely and set it as the active resume for visitors to download.
            </p>

            <form action="{{ route('admin.resume.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="resume_file" class="form-label" style="font-size: 0.88rem;">Select PDF Document (Max: 5 MB)</label>
                    <input type="file" 
                           name="resume_file" 
                           id="resume_file" 
                           class="form-control" 
                           accept="application/pdf" 
                           required>
                    <small class="text-muted">Only PDF files are accepted. Safe random filenames are generated automatically.</small>
                </div>

                <button type="submit" class="btn-glass btn-glass-primary">
                    <i class="bi bi-cloud-arrow-up-fill"></i>
                    <span>Upload &amp; Activate Resume</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Upload History Table -->
<div class="glass p-4">
    <h5 class="font-heading mb-3">Resume Upload History</h5>

    @if($resumes->isEmpty())
        <p class="text-muted text-center py-4 mb-0">No resumes uploaded yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="text-muted" style="font-size: 0.85rem;">
                        <th>File Name</th>
                        <th>Size</th>
                        <th>Upload Date</th>
                        <th>Status</th>
                        <th>Downloads</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resumes as $item)
                        <tr>
                            <td>
                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                <span style="font-weight: 500;">{{ $item->original_name }}</span>
                            </td>
                            <td>{{ number_format($item->file_size / 1024, 1) }} KB</td>
                            <td>{{ $item->created_at->format('M d, Y - h:i A') }}</td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $item->download_count }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ Storage::url($item->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Preview">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if(!$item->is_active)
                                        <form action="{{ route('admin.resume.set-active', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Set Active">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.resume.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this resume file?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
