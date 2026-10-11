@extends('admin.layout')

@section('title', 'Projects Manager')
@section('page_title', 'Projects Portfolio')
@section('page_subtitle', 'Manage projects, live links, categories, and technologies')

@section('page_actions')
    <a href="{{ route('admin.projects.create') }}" class="btn-glass btn-glass-primary py-1 px-3" style="font-size: 0.85rem;">
        <i class="bi bi-plus-lg"></i> Add Project
    </a>
@endsection

@section('content')

<div class="glass p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="text-muted" style="font-size: 0.85rem;">
                    <th>Preview</th>
                    <th>Title &amp; Category</th>
                    <th>Tech Stack</th>
                    <th>Featured</th>
                    <th>Live Link</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $proj)
                    <tr>
                        <td style="width: 70px;">
                            <img src="{{ asset($proj->image) }}" alt="{{ $proj->title }}" width="64" height="42" class="rounded object-fit-cover" style="object-fit: cover;">
                        </td>
                        <td>
                            <strong style="color: var(--text-main);">{{ $proj->title }}</strong>
                            <small class="text-muted d-block">{{ $proj->category }}</small>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1" style="max-width: 280px;">
                                @foreach($proj->tech_stack as $t)
                                    <span class="badge bg-secondary" style="font-size: 0.7rem;">{{ $t }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            @if($proj->is_featured)
                                <span class="badge bg-success">Featured</span>
                            @else
                                <span class="badge bg-dark">Standard</span>
                            @endif
                        </td>
                        <td>
                            @if($proj->live_url)
                                <a href="{{ $proj->live_url }}" target="_blank" class="text-accent text-decoration-none" style="font-size: 0.85rem;">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Visit
                                </a>
                            @else
                                <span class="text-muted" style="font-size: 0.85rem;">None</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.projects.edit', $proj) }}" class="btn btn-sm btn-outline-info" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.projects.destroy', $proj) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this project?');">
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
</div>

@endsection
