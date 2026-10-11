@extends('layouts.app')

@section('title', $project->title . ' | Project — Rohit Verma')
@section('meta_description', Str::limit($project->description, 155))

@section('content')

<div style="padding: 3rem 0 6rem;">
    <div class="container">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4" data-aos="fade-down">
            <ol class="breadcrumb" style="background:transparent; padding:0;">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" style="color:var(--accent);">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('projects') }}" style="color:var(--accent);">Projects</a>
                </li>
                <li class="breadcrumb-item active text-muted" aria-current="page">{{ $project->title }}</li>
            </ol>
        </nav>

        <div class="row g-5 align-items-start">

            {{-- Left: Project Screenshot + Quick Info --}}
            <div class="col-lg-5" data-aos="fade-right" data-aos-duration="800">

                {{-- Thumbnail Card --}}
                <div class="glass-card mb-4" style="overflow:hidden; border-radius:20px;">
                    <img src="{{ asset($project->image ?? 'images/projects/placeholder.svg') }}"
                         alt="{{ $project->title }}"
                         class="img-fluid w-100"
                         loading="eager"
                         style="display:block; border-radius:20px;">
                </div>

                {{-- Quick Info Glass Card --}}
                <div class="glass p-4">
                    <h4 class="font-heading mb-4" style="font-size:1rem; text-transform:uppercase; letter-spacing:.08em; color:var(--accent);">Project Info</h4>

                    <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom:1px solid rgba(255,255,255,.08);">
                        <span class="text-muted" style="font-size:.88rem;">Category</span>
                        <span class="glass-badge glass-badge-accent">{{ $project->category }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom:1px solid rgba(255,255,255,.08);">
                        <span class="text-muted" style="font-size:.88rem;">Status</span>
                        @if($project->live_url)
                            <span class="glass-badge" style="background:rgba(16,185,129,.15); border-color:rgba(16,185,129,.3); color:#34D399; font-size:.75rem;">
                                <i class="bi bi-circle-fill me-1" style="font-size:.55rem;"></i> Live & Active
                            </span>
                        @else
                            <span class="glass-badge" style="font-size:.75rem;">
                                <i class="bi bi-lock-fill me-1" style="font-size:.7rem;"></i> Private
                            </span>
                        @endif
                    </div>

                    <div class="py-2" style="border-bottom:1px solid rgba(255,255,255,.08);">
                        <span class="text-muted d-block mb-2" style="font-size:.88rem;">Tech Stack</span>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($project->tech_stack as $tech)
                                <span class="glass-badge glass-badge-primary" style="font-size:.73rem;">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-4 d-flex flex-column gap-2">
                        @if($project->live_url)
                            <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer"
                               class="btn-glass btn-glass-primary d-flex justify-content-center">
                                <i class="bi bi-box-arrow-up-right"></i>
                                <span>Visit Live Website</span>
                            </a>
                        @endif
                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                               class="btn-glass d-flex justify-content-center">
                                <i class="bi bi-github"></i>
                                <span>View on GitHub</span>
                            </a>
                        @endif
                        <a href="{{ route('contact') }}" class="btn-glass d-flex justify-content-center">
                            <i class="bi bi-chat-dots"></i>
                            <span>Enquire About Similar Build</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right: Project Details --}}
            <div class="col-lg-7" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100">

                <span class="section-tag">{{ $project->category }}</span>
                <h1 class="section-title mb-3">{{ $project->title }}</h1>

                {{-- Short Description Glass Block --}}
                <div class="glass p-4 mb-4" style="border-left: 4px solid var(--accent); border-radius:16px;">
                    <p class="mb-0" style="color:var(--text-secondary); line-height:1.85; font-size:1.05rem;">
                        {{ $project->description }}
                    </p>
                </div>

                {{-- Long Description --}}
                @if($project->long_description)
                    <h4 class="font-heading mb-3" style="color:var(--text-secondary); font-size:1.05rem;">Project Overview</h4>
                    <div class="glass p-4 mb-5" style="border-radius:16px;">
                        <p style="color:var(--text-secondary); line-height:1.85; margin-bottom:0;">
                            {{ $project->long_description }}
                        </p>
                    </div>
                @endif

                {{-- Key Features (static per project) --}}
                <h4 class="font-heading mb-3" style="color:var(--text-secondary); font-size:1.05rem;">Key Highlights</h4>
                <div class="row g-3 mb-5">
                    @php
                        $highlights = [
                            'Responsive UI (mobile-first with Bootstrap 5.3)',
                            'Laravel MVC Architecture with clean codebase',
                            'Secure data handling & CSRF protection',
                            'Optimized MySQL queries with Eloquent ORM',
                            'RESTful API design & integration-ready',
                            'Role-based access control and authentication',
                        ];
                    @endphp
                    @foreach($highlights as $feat)
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-2">
                                <div style="width:28px;height:28px;border-radius:8px;background:rgba(6,182,212,.15);border:1px solid rgba(6,182,212,.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                                    <i class="bi bi-check-lg" style="color:var(--accent);font-size:.85rem;"></i>
                                </div>
                                <span style="color:var(--text-secondary); font-size:.92rem; line-height:1.6;">{{ $feat }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Back & Related Navigation --}}
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <a href="{{ route('projects') }}" class="btn-glass">
                        <i class="bi bi-arrow-left"></i> All Projects
                    </a>
                    <a href="{{ route('contact') }}" class="btn-glass btn-glass-primary">
                        <i class="bi bi-lightning-charge-fill"></i> Hire Me for a Similar Build
                    </a>
                </div>

            </div>
        </div>

        {{-- Related Projects Section --}}
        @if($relatedProjects->isNotEmpty())
            <div class="mt-5 pt-3">
                <h3 class="font-heading mb-4" style="font-size:1.35rem;">
                    <i class="bi bi-grid me-2" style="color:var(--accent);"></i>More Projects
                </h3>
                <div class="row g-4">
                    @foreach($relatedProjects as $related)
                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <a href="{{ route('projects.show', $related->slug) }}" class="text-decoration-none">
                                <div class="glass-card d-flex gap-3 align-items-center p-3" style="border-radius:16px;">
                                    <img src="{{ asset($related->image ?? 'images/projects/placeholder.svg') }}"
                                         alt="{{ $related->title }}"
                                         width="80" height="60"
                                         class="rounded-3 object-fit-cover flex-shrink-0"
                                         style="object-fit:cover; width:80px; height:60px;"
                                         loading="lazy">
                                    <div>
                                        <span class="glass-badge glass-badge-accent mb-1" style="font-size:.7rem;">{{ $related->category }}</span>
                                        <h5 class="mb-1" style="font-size:.95rem; color:var(--text-primary);">{{ $related->title }}</h5>
                                        <p class="mb-0" style="font-size:.8rem; color:var(--text-muted);">
                                            {{ Str::limit($related->description, 70) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

@endsection
