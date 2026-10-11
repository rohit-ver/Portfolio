@extends('layouts.app')

@section('title', \App\Models\Setting::get('meta_title', 'Rohit Verma | Full Stack Web Developer (Laravel / PHP)'))
@section('meta_description', \App\Models\Setting::get('meta_description', 'Official portfolio of Rohit Verma — Senior Full Stack Web Developer crafting high-performance, elegant web applications with Laravel, PHP, and MySQL.'))

@section('content')

{{-- ╔═══════════════════════════════════════════╗ --}}
{{-- ║            HERO SECTION                  ║ --}}
{{-- ╚═══════════════════════════════════════════╝ --}}
<section class="hero-section" id="hero">
    <div class="container">
        <div class="row align-items-center gy-5">

            <!-- Hero Left: Text Content -->
            <div class="col-lg-7 col-xl-6 order-2 order-lg-1" data-aos="fade-right" data-aos-duration="900">

                <!-- "Open to Work" Pill Badge -->
                <div class="hero-pill-badge mb-4">
                    <span class="status-dot"></span>
                    <span>Open to Work &bull; Full-time &amp; Contracts</span>
                </div>

                <!-- Main Heading -->
                <h1 class="hero-title mb-3">
                    {{ \App\Models\Setting::get('hero_title', 'Hi, I\'m') }} <br>
                    <span class="gradient-text">{{ \App\Models\Setting::get('hero_name', 'Rohit Verma') }}</span>
                </h1>

                <!-- Animated Typing Role -->
                <div class="hero-typing-wrap mb-4">
                    <span id="typingText" aria-live="polite"></span>
                    <span class="typing-cursor" aria-hidden="true">&nbsp;</span>
                </div>

                <!-- Short Bio -->
                <p class="hero-description">
                    {{ \App\Models\Setting::get('hero_bio', 'I architect robust, scalable web systems with Laravel & PHP — from elegant APIs to pixel-perfect frontends. Turning complex business challenges into fast, maintainable digital products is my craft.') }}
                </p>

                <!-- CTA Buttons -->
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="{{ route('projects') }}" class="btn-glass btn-glass-primary">
                        <i class="bi bi-code-slash"></i>
                        <span>View My Projects</span>
                    </a>
                    
                    @if($activeResume)
                        <a href="{{ route('resume.download') }}" 
                           class="btn-glass btn-glass-resume"
                           data-track="resume_download"
                           data-label="Hero Download Resume">
                            <i class="bi bi-download"></i>
                            <span>Download Resume</span>
                        </a>
                    @endif

                    <a href="{{ route('contact') }}" class="btn-glass">
                        <i class="bi bi-envelope"></i>
                        <span>Let's Talk</span>
                    </a>
                </div>

                <!-- Social Links -->
                <div class="d-flex align-items-center gap-3 mt-2">
                    <span class="text-muted" style="font-size:.85rem;">Find me on:</span>
                    <a href="{{ \App\Models\Setting::get('social_github', 'https://github.com/rohitv3319') }}"
                       target="_blank" rel="noopener noreferrer"
                       class="btn-glass btn-glass-icon"
                       title="GitHub" aria-label="GitHub Profile">
                        <i class="bi bi-github"></i>
                    </a>
                    <a href="{{ \App\Models\Setting::get('social_linkedin', 'https://www.linkedin.com/in/rohit-verma') }}"
                       target="_blank" rel="noopener noreferrer"
                       class="btn-glass btn-glass-icon"
                       title="LinkedIn" aria-label="LinkedIn Profile">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="mailto:{{ \App\Models\Setting::get('owner_email', 'rohitv3319@gmail.com') }}"
                       class="btn-glass btn-glass-icon"
                       title="Email" aria-label="Send Email">
                        <i class="bi bi-envelope-fill"></i>
                    </a>
                </div>
            </div>

            <!-- Hero Right: Glass Profile Card (Requirement 2) -->
            <div class="col-lg-5 col-xl-6 order-1 order-lg-2 d-flex justify-content-center" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="150">
                <div class="hero-profile-card" style="max-width:390px; width:100%;">

                    <!-- Photo with Gradient Glowing Border -->
                    <div class="hero-avatar-wrapper">
                        @php
                            $imgSrc = $profileImage ? asset($profileImage) : asset('images/profile-placeholder.png');
                        @endphp
                        <img src="{{ $imgSrc }}" 
                             alt="Rohit Verma — {{ $designation }}" 
                             class="hero-avatar-img"
                             loading="eager"
                             width="170" height="170"
                             onerror="this.src='{{ asset('images/profile-placeholder.png') }}'">
                    </div>

                    <!-- Name -->
                    <h2 class="hero-card-name">Rohit Verma</h2>

                    <!-- Designation (editable via admin settings) -->
                    <p class="hero-card-role">{{ $designation }}</p>

                    <!-- Badges: Laravel, PHP, Open to Work -->
                    <div class="hero-card-badges">
                        <span class="glass-badge glass-badge-primary">
                            <i class="bi bi-fire" style="color: #F43F5E;"></i> Laravel
                        </span>
                        <span class="glass-badge glass-badge-accent">
                            <i class="bi bi-filetype-php" style="color: #818CF8;"></i> PHP 8.2+
                        </span>
                        <span class="glass-badge glass-badge-success">
                            <span class="status-dot" style="width:6px;height:6px;"></span> Open to Work
                        </span>
                    </div>

                    <!-- Action in card -->
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('contact') }}" 
                           class="btn-glass btn-glass-primary w-100 justify-content-center" 
                           style="font-size:0.9rem;"
                           data-track="hire_me_click"
                           data-label="Profile Card Hire Me">
                            <i class="bi bi-lightning-charge-fill"></i> Hire Me
                        </a>
                        @if($activeResume)
                            <a href="{{ route('resume.download') }}" 
                               class="btn-glass btn-glass-resume justify-content-center" 
                               title="Download Resume"
                               data-track="resume_download"
                               data-label="Profile Card Download Resume">
                                <i class="bi bi-download"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ╔═══════════════════════════════════════════╗ --}}
{{-- ║            ABOUT SECTION                 ║ --}}
{{-- ╚═══════════════════════════════════════════╝ --}}
<section class="py-6" id="about" style="padding: 5rem 0;">
    <div class="container">
        <div class="row gy-5 align-items-center">

            <!-- Left: About Text -->
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="800">
                <span class="section-tag">About Me</span>
                <h2 class="section-title">Building the Web,<br><span class="gradient-text">One Line at a Time</span></h2>

                <div class="glass p-4 mb-4" style="border-radius:16px;">
                    <p class="mb-3" style="color: var(--text-secondary); line-height:1.8;">
                        I'm <strong style="color:var(--text-main);">Rohit Verma</strong>, a freelance PHP & Laravel Developer from Rajasthan, India specializing in building
                        <strong style="color:var(--accent);">responsive, dynamic, and database-driven websites.</strong> 
                    </p>
                    <p class="mb-3" style="color: var(--text-secondary); line-height:1.8;">
                        Currently working at <strong style="color:var(--text-main);">Pratham Software Pvt. Ltd.</strong> My work includes identifying potential international clients, researching target companies, managing and cleaning prospect data, and supporting email and LinkedIn outreach campaigns to generate business opportunities for IT services.
                    </p>
                    <p class="mb-0" style="color: var(--text-secondary); line-height:1.8;">
                        When I'm not building web applications, I'm exploring new Laravel packages, contributing to open source,
                        and continuously refining my craft as a modern web artisan.
                    </p>
                </div>

                <!-- Tech Tags -->
                <div class="d-flex flex-wrap gap-2">
                    @foreach(['Laravel', 'PHP 8.2+', 'MySQL', 'REST APIs', 'Bootstrap 5', 'Git', 'JavaScript'] as $tag)
                        <span class="glass-badge">
                            <i class="bi bi-check-circle-fill" style="color: var(--accent); font-size:.7rem;"></i>
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Right: Stats Grid -->
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="800" data-aos-delay="150">
                <div class="row g-4" id="statsSection">
                    <div class="col-6">
                        <div class="stat-box glass">
                            <div class="stat-number stat-counter" data-target="{{ $stats['projects_count'] }}">{{ $stats['projects_count'] }}+</div>
                            <div class="stat-label">
                                <i class="bi bi-code-slash me-1"></i>Projects Delivered
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-box glass">
                            <div class="stat-number stat-counter" data-target="{{ $stats['years_experience'] }}">{{ $stats['years_experience'] }}+</div>
                            <div class="stat-label">
                                <i class="bi bi-calendar3 me-1"></i>Years of Experience
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-box glass">
                            <div class="stat-number stat-counter" data-target="{{ $stats['satisfied_clients'] }}">{{ $stats['satisfied_clients'] }}+</div>
                            <div class="stat-label">
                                <i class="bi bi-emoji-smile me-1"></i>Satisfied Clients
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-box glass">
                            <div class="stat-number stat-counter" data-target="{{ $stats['commits_count'] }}">{{ $stats['commits_count'] }}+</div>
                            <div class="stat-label">
                                <i class="bi bi-git me-1"></i>Git Commits
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="text-center mt-4 d-flex justify-content-center gap-3 flex-wrap">
                    @if($activeResume)
                        <a href="{{ route('resume.download') }}" class="btn-glass btn-glass-resume d-inline-flex">
                            <i class="bi bi-download"></i>
                            <span>Download Resume (PDF)</span>
                        </a>
                    @endif
                    <a href="{{ route('experience') }}" class="btn-glass d-inline-flex">
                        <i class="bi bi-briefcase"></i>
                        <span>View Work Experience</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ╔═══════════════════════════════════════════╗ --}}
{{-- ║            SKILLS SECTION                ║ --}}
{{-- ╚═══════════════════════════════════════════╝ --}}
@if(isset($skills) && $skills->isNotEmpty())
<section class="py-6" id="skills" style="padding: 5rem 0;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-tag">Technical Arsenal</span>
            <h2 class="section-title">Skills &amp; Expertise</h2>
            <p class="section-subtitle mx-auto">
                A robust, production-tested technology stack for building scalable web applications
                — from database to deployment.
            </p>
        </div>

        @php
            $categoryIcons = [
                'Backend' => 'bi-server',
                'Frontend' => 'bi-palette',
                'Database' => 'bi-database',
                'Tools' => 'bi-tools',
                'General' => 'bi-lightning-charge',
            ];
        @endphp

        @foreach($skills as $categoryName => $categorySkills)
            <div class="mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi {{ $categoryIcons[$categoryName] ?? 'bi-layers' }}" style="color: var(--accent); font-size: 1.1rem;"></i>
                    <h4 class="font-heading mb-0" style="font-size:1.05rem; color: var(--text-secondary);">
                        {{ $categoryName }}
                    </h4>
                </div>
                <div class="row g-3">
                    @foreach($categorySkills as $skill)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="glass-card skill-card">
                                <div>
                                    <div class="skill-icon-wrap">
                                        @if($skill->icon_type === 'image' && $skill->icon_image)
                                            <img src="{{ asset($skill->icon_image) }}" 
                                                 alt="{{ $skill->name }}" 
                                                 style="width: 28px; height: 28px; object-fit: contain;">
                                        @elseif($skill->icon_class)
                                            <i class="{{ $skill->icon_class }}"></i>
                                        @else
                                            <i class="bi bi-code-slash"></i>
                                        @endif
                                    </div>
                                    <h5 class="skill-title mb-1">{{ $skill->name }}</h5>
                                    @if($skill->category)
                                        <small class="text-muted d-block mb-3" style="font-size: 0.8rem;">{{ $skill->category }}</small>
                                    @endif
                                </div>
                                
                                @if(!is_null($skill->proficiency))
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="glass-badge glass-badge-primary" style="font-size:.72rem; padding:.2rem .6rem;">
                                                Proficiency
                                            </span>
                                            <span style="font-size:.8rem; color: var(--accent); font-weight:600;">{{ $skill->proficiency }}%</span>
                                        </div>
                                        <div class="skill-bar-wrap">
                                            <div class="skill-bar-progress" style="width: 0%;" data-width="{{ $skill->proficiency }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif


{{-- ╔═══════════════════════════════════════════╗ --}}
{{-- ║          FEATURED PROJECTS SECTION       ║ --}}
{{-- ╚═══════════════════════════════════════════╝ --}}
<section class="py-6" id="projects" style="padding: 5rem 0;">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-5">
            <div data-aos="fade-right">
                <span class="section-tag">Work Portfolio</span>
                <h2 class="section-title mb-0">Featured Projects</h2>
            </div>
            <div data-aos="fade-left">
                <a href="{{ route('projects') }}" class="btn-glass">
                    View All Projects <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            @foreach($featuredProjects as $project)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 120 }}">
                    <div class="glass-card project-card h-100">
                        <div class="project-thumb-container">
                            <img src="{{ asset($project->image ?? 'images/projects/placeholder.svg') }}"
                                 alt="{{ $project->title }}"
                                 class="project-thumb"
                                 loading="lazy"
                                 width="600" height="360">
                            <div class="project-thumb-overlay"></div>
                            <div class="project-thumb-category">
                                <span class="glass-badge glass-badge-accent">{{ $project->category }}</span>
                            </div>
                        </div>

                        <div class="project-card-body">
                            <h3 class="project-card-title">{{ $project->title }}</h3>
                            <p class="project-card-desc">{{ $project->description }}</p>

                            <div class="project-tech-badges">
                                @foreach($project->tech_stack as $tech)
                                    <span class="glass-badge">{{ $tech }}</span>
                                @endforeach
                            </div>

                            <div class="project-card-footer">
                                <a href="{{ route('projects.show', $project->slug) }}" class="btn-glass" style="font-size:.85rem; padding:.5rem 1.2rem;">
                                    <i class="bi bi-info-circle"></i> Details
                                </a>
                                @if($project->live_url)
                                    <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer"
                                       class="btn-glass btn-glass-primary" style="font-size:.85rem; padding:.5rem 1.2rem;"
                                       data-track="project_live_demo"
                                       data-label="{{ $project->title }}">
                                        <i class="bi bi-box-arrow-up-right"></i> Live Demo
                                    </a>
                                @else
                                    <span class="glass-badge" style="font-size:.75rem;">
                                        <i class="bi bi-lock-fill me-1"></i>Private Build
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ╔═══════════════════════════════════════════╗ --}}
{{-- ║          CTA "LET'S WORK TOGETHER"       ║ --}}
{{-- ╚═══════════════════════════════════════════╝ --}}
<section style="padding: 5rem 0 6rem;" id="cta">
    <div class="container">
        <div class="glass text-center" style="padding: 4rem 2rem;" data-aos="zoom-in" data-aos-duration="800">

            <div style="width:80px; height:80px; border-radius:50%; background:linear-gradient(135deg, var(--primary), var(--accent)); margin:0 auto 2rem; display:flex; align-items:center; justify-content:center; box-shadow: 0 0 40px rgba(79, 70, 229, 0.5);">
                <i class="bi bi-rocket-takeoff-fill text-white" style="font-size:2rem;"></i>
            </div>

            <h2 class="font-heading mb-3" style="font-size: clamp(1.8rem, 4vw, 2.6rem);">
                Ready to <span class="gradient-text">Build Something Amazing?</span>
            </h2>
            <p class="text-muted mx-auto mb-4" style="max-width:600px; font-size:1.08rem; line-height:1.8;">
                Whether you need a powerful Laravel backend, a sleek full-stack web application, or strategic web consulting —
                let's connect and turn your vision into reality.
            </p>

            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ route('contact') }}" class="btn-glass btn-glass-primary">
                    <i class="bi bi-send-fill"></i>
                    <span>Start a Project</span>
                </a>
                @if($activeResume)
                    <a href="{{ route('resume.download') }}" class="btn-glass btn-glass-resume">
                        <i class="bi bi-download"></i>
                        <span>Download CV</span>
                    </a>
                @endif
                <a href="mailto:{{ \App\Models\Setting::get('owner_email', 'rohitv3319@gmail.com') }}" class="btn-glass">
                    <i class="bi bi-envelope-open-fill"></i>
                    <span>{{ \App\Models\Setting::get('owner_email', 'rohitv3319@gmail.com') }}</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const bars = document.querySelectorAll('.skill-bar-progress');
    if (!bars.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                const targetWidth = bar.getAttribute('data-width');
                bar.style.width = targetWidth;
                observer.unobserve(bar);
            }
        });
    }, { threshold: 0.3 });

    bars.forEach(bar => observer.observe(bar));
});
</script>
@endpush
