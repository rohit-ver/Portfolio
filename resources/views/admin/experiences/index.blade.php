@extends('admin.layout')

@section('title', 'Work Experience Manager')
@section('page_title', 'Work Experience')
@section('page_subtitle', 'Manage career timeline entries, companies, and roles')

@section('page_actions')
    <a href="{{ route('admin.experiences.create') }}" class="btn-glass btn-glass-primary py-1 px-3" style="font-size: 0.85rem;">
        <i class="bi bi-plus-lg"></i> Add Experience
    </a>
@endsection

@section('content')

<div class="glass p-4">
    @if($experiences->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-briefcase text-muted fs-1 mb-3 d-block"></i>
            <h5>No Experience Entries</h5>
            <p class="text-muted">Click "Add Experience" to add your first job or role.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="text-muted" style="font-size: 0.85rem;">
                        <th>Company</th>
                        <th>Role / Designation</th>
                        <th>Duration</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($experiences as $exp)
                        <tr>
                            <td>
                                <strong style="color: var(--text-main);">{{ $exp->company }}</strong>
                                @if($exp->location)
                                    <small class="text-muted d-block">{{ $exp->location }}</small>
                                @endif
                            </td>
                            <td>
                                <span style="color: var(--accent); font-weight: 500;">{{ $exp->designation }}</span>
                            </td>
                            <td>
                                {{ $exp->start_date->format('M Y') }} – {{ $exp->is_current ? 'Present' : ($exp->end_date ? $exp->end_date->format('M Y') : 'N/A') }}
                            </td>
                            <td>{{ $exp->type }}</td>
                            <td>
                                @if($exp->is_current)
                                    <span class="badge bg-success">Currently Working</span>
                                @else
                                    <span class="badge bg-secondary">Completed</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.experiences.edit', $exp) }}" class="btn btn-sm btn-outline-info" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.experiences.destroy', $exp) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this experience entry?');">
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
