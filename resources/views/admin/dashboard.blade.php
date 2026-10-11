@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard Overview')
@section('page_subtitle', 'Welcome back, ' . Auth::user()->name . '!')

@section('page_actions')
    <a href="{{ route('admin.projects.create') }}" class="btn-glass btn-glass-primary py-1 px-3" style="font-size: 0.85rem;">
        <i class="bi bi-plus-lg"></i> Add Project
    </a>
    <a href="{{ route('admin.experiences.create') }}" class="btn-glass py-1 px-3" style="font-size: 0.85rem;">
        <i class="bi bi-plus-lg"></i> Add Experience
    </a>
@endsection

@section('content')

<!-- Quick Metrics Cards -->
<div class="row g-3 mb-5">
    <div class="col-sm-6 col-xl-3">
        <div class="glass p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted" style="font-size: 0.85rem;">Total Projects</span>
                <i class="bi bi-code-slash fs-4" style="color: var(--accent);"></i>
            </div>
            <h3 class="font-heading mb-0">{{ $metrics['projects'] }}</h3>
            <small class="text-muted"><a href="{{ route('admin.projects.index') }}" class="text-accent text-decoration-none">Manage &rarr;</a></small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="glass p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted" style="font-size: 0.85rem;">Work Experiences</span>
                <i class="bi bi-briefcase fs-4" style="color: var(--primary-light);"></i>
            </div>
            <h3 class="font-heading mb-0">{{ $metrics['experiences'] }}</h3>
            <small class="text-muted"><a href="{{ route('admin.experiences.index') }}" class="text-accent text-decoration-none">Manage &rarr;</a></small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="glass p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted" style="font-size: 0.85rem;">Contact Messages</span>
                <i class="bi bi-envelope-paper fs-4" style="color: #F59E0B;"></i>
            </div>
            <h3 class="font-heading mb-0 d-flex align-items-center gap-2">
                {{ $metrics['messages'] }}
                @if($metrics['unread_messages'] > 0)
                    <span class="badge bg-danger fs-6">{{ $metrics['unread_messages'] }} new</span>
                @endif
            </h3>
            <small class="text-muted"><a href="{{ route('admin.contacts.index') }}" class="text-accent text-decoration-none">Inbox &rarr;</a></small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="glass p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted" style="font-size: 0.85rem;">Resume Downloads</span>
                <i class="bi bi-download fs-4" style="color: #10B981;"></i>
            </div>
            <h3 class="font-heading mb-0">{{ $metrics['resume_downloads'] }}</h3>
            <small class="text-muted">
                @if($metrics['active_resume'])
                    <span class="text-success"><i class="bi bi-check-circle me-1"></i>Active: {{ Str::limit($metrics['active_resume']->original_name, 16) }}</span>
                @else
                    <span class="text-danger"><i class="bi bi-exclamation-circle me-1"></i>No resume active</span>
                @endif
            </small>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Messages -->
    <div class="col-lg-6">
        <div class="glass p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="font-heading mb-0" style="font-size: 1.1rem;">Recent Inquiries</h5>
                <a href="{{ route('admin.contacts.index') }}" class="text-accent text-decoration-none" style="font-size: 0.85rem;">View All</a>
            </div>

            @if($recentMessages->isEmpty())
                <p class="text-muted py-4 text-center mb-0">No contact messages received yet.</p>
            @else
                <div class="list-group list-group-flush bg-transparent">
                    @foreach($recentMessages as $msg)
                        <a href="{{ route('admin.contacts.show', $msg) }}" class="list-group-item list-group-item-action bg-transparent border-0 px-0 py-2 d-flex justify-content-between align-items-center">
                            <div>
                                <strong class="d-block" style="color: var(--text-main); font-size: 0.95rem;">
                                    {{ $msg->name }}
                                    @if(!$msg->is_read)
                                        <span class="badge bg-primary ms-1" style="font-size: 0.65rem;">NEW</span>
                                    @endif
                                </strong>
                                <small class="text-muted">{{ Str::limit($msg->subject, 36) }}</small>
                            </div>
                            <small class="text-muted">{{ $msg->created_at->diffForHumans() }}</small>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Active Projects Preview -->
    <div class="col-lg-6">
        <div class="glass p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="font-heading mb-0" style="font-size: 1.1rem;">Projects Portfolio</h5>
                <a href="{{ route('admin.projects.index') }}" class="text-accent text-decoration-none" style="font-size: 0.85rem;">Manage All</a>
            </div>

            <div class="list-group list-group-flush bg-transparent">
                @foreach($recentProjects as $proj)
                    <div class="list-group-item bg-transparent border-0 px-0 py-2 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset($proj->image) }}" alt="{{ $proj->title }}" width="48" height="32" class="rounded object-fit-cover" style="object-fit: cover;">
                            <div>
                                <strong class="d-block" style="color: var(--text-main); font-size: 0.95rem;">{{ $proj->title }}</strong>
                                <small class="text-muted">{{ $proj->category }}</small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.projects.edit', $proj) }}" class="btn btn-sm btn-outline-info" style="font-size: 0.75rem;">Edit</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
