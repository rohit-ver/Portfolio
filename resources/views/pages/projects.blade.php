@extends('layouts.app')

@section('title', 'All Projects | Rohit Verma — Laravel Web Developer')
@section('meta_description', 'Explore the complete portfolio of web development projects by Rohit Verma — including Laravel applications, B2B platforms, social initiative sites, and automotive booking systems.')

@section('content')

<div style="padding: 3.5rem 0 6rem;">
    <div class="container">

        {{-- Page Header --}}
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-tag">My Work</span>
            <h1 class="section-title">All Projects</h1>
            <p class="section-subtitle mx-auto">
                A curated collection of production-ready web applications built with
                <strong style="color: var(--accent);">Laravel, PHP, MySQL</strong> and modern frontend technologies.
            </p>
        </div>

        {{-- Category Filter Buttons --}}
        @if($categories->isNotEmpty())
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5" data-aos="fade-up" data-aos-delay="100">
            <button class="btn-glass project-filter-btn active" data-filter="all">
                <i class="bi bi-grid-3x3-gap-fill me-1"></i> All Projects
            </button>
            @foreach($categories as $cat)
                <button class="btn-glass project-filter-btn" data-filter="{{ $cat }}">
                    {{ $cat }}
                </button>
            @endforeach
        </div>
        @endif

        {{-- Projects Grid --}}
        <div class="row g-4">
            @forelse($projects as $project)
                <div class="col-lg-4 col-md-6 project-item"
                     data-category="{{ $project->category }}"
                     data-aos="fade-up"
                     data-aos-delay="{{ ($loop->index % 3) * 100 }}"
                     style="transition: opacity .25s ease, transform .25s ease;">

                    <div class="glass-card project-card h-100">

                        {{-- Thumbnail --}}
                        <div class="project-thumb-container">
                            <img src="{{ asset($project->image ?? 'images/projects/placeholder.svg') }}"
                                 alt="{{ $project->title }} — Project Screenshot"
                                 class="project-thumb"
                                 loading="lazy" width="600" height="360">
                            <div class="project-thumb-overlay"></div>

                            {{-- Category badge over thumb --}}
                            <div class="project-thumb-category">
                                <span class="glass-badge glass-badge-accent">{{ $project->category }}</span>
                            </div>

                            {{-- Live badge if URL exists --}}
                            @if($project->live_url)
                                <div style="position:absolute; bottom:14px; right:14px; z-index:3;">
                                    <span class="glass-badge" style="font-size:.72rem; background:rgba(16,185,129,.18); border-color:rgba(16,185,129,.35); color:#34D399;">
                                        <i class="bi bi-circle-fill" style="font-size:.5rem;"></i> Live
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="project-card-body">
                            <h2 class="project-card-title" style="font-size:1.2rem;">{{ $project->title }}</h2>
                            <p class="project-card-desc">{{ $project->description }}</p>

                            {{-- Tech Stack Badges --}}
                            <div class="project-tech-badges">
                                @foreach($project->tech_stack as $tech)
                                    <span class="glass-badge">{{ $tech }}</span>
                                @endforeach
                            </div>

                            {{-- Actions --}}
                            <div class="project-card-footer">
                                <a href="{{ route('projects.show', $project->slug) }}" class="btn-glass" style="font-size:.85rem; padding:.5rem 1.15rem;">
                                    <i class="bi bi-info-circle"></i> Details
                                </a>
                                <div class="d-flex gap-2">
                                    @if($project->live_url)
                                        <a href="{{ $project->live_url }}"
                                           target="_blank" rel="noopener noreferrer"
                                           class="btn-glass btn-glass-primary"
                                           style="font-size:.85rem; padding:.5rem 1.15rem;"
                                           data-track="project_live_demo"
                                           data-label="{{ $project->title }}">
                                            <i class="bi bi-box-arrow-up-right"></i> Live Demo
                                        </a>
                                    @endif
                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}"
                                           target="_blank" rel="noopener noreferrer"
                                           class="btn-glass btn-glass-icon"
                                           title="View on GitHub" aria-label="GitHub">
                                            <i class="bi bi-github"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5" data-aos="fade-up">
                    <div class="glass p-5" style="border-radius:20px;">
                        <i class="bi bi-folder-x" style="font-size:4rem; color:var(--text-muted); display:block; margin-bottom:1.5rem;"></i>
                        <h3 class="mb-2" style="color:var(--text-muted);">No Projects Yet</h3>
                        <p class="text-muted">Projects will appear here once added to the database. Run <code>php artisan db:seed</code> to seed sample data.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- CTA Strip --}}
        <div class="text-center mt-6 pt-3" style="margin-top:4rem;" data-aos="zoom-in">
            <p class="text-muted mb-3">Have a project idea in mind? Let's build it together.</p>
            <a href="{{ route('contact') }}" class="btn-glass btn-glass-primary">
                <i class="bi bi-send-fill"></i>
                <span>Discuss Your Project</span>
            </a>
        </div>

    </div>
</div>

@endsection
