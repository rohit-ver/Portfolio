<header class="navbar-glass-wrapper">
    <nav class="navbar navbar-expand-lg navbar-glass" id="mainNavbar">
        <div class="container-fluid px-0">
            <!-- Brand Logo with "RM" Badge -->
            <a class="navbar-brand brand-logo-badge" href="{{ route('home') }}" aria-label="Rohit Verma Portfolio Home">
                <div class="logo-icon-box">
                    <span class="logo-text">RM</span>
                </div>
                <div class="d-flex flex-column">
                    <span class="brand-title">Rohit Verma</span>
                    <span class="brand-role">Laravel Artisan</span>
                </div>
            </a>

            <!-- Mobile Hamburger Toggle -->
            <button class="navbar-toggler border-0 text-white shadow-none" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#portfolioNavContent" 
                    aria-controls="portfolioNavContent" 
                    aria-expanded="false" 
                    aria-label="Toggle navigation">
                <i class="bi bi-list fs-2 text-white"></i>
            </button>

            <!-- Navigation Links & Actions -->
            <div class="collapse navbar-collapse" id="portfolioNavContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link nav-link-glass {{ request()->routeIs('home') ? 'active' : '' }}" 
                           href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1 d-lg-none"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-glass {{ request()->routeIs('experience') ? 'active' : '' }}" 
                           href="{{ route('experience') }}">
                            <i class="bi bi-briefcase me-1 d-lg-none"></i> Experience
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-glass {{ request()->routeIs('projects*') ? 'active' : '' }}" 
                           href="{{ route('projects') }}">
                            <i class="bi bi-code-slash me-1 d-lg-none"></i> Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-glass {{ request()->routeIs('contact') ? 'active' : '' }}" 
                           href="{{ route('contact') }}">
                            <i class="bi bi-envelope me-1 d-lg-none"></i> Contact
                        </a>
                    </li>
                </ul>

                <!-- Right Side Actions: Resume Download, Theme Switcher & "Hire Me" Button -->
                <div class="d-flex align-items-center gap-2 gap-lg-3 mt-3 mt-lg-0 flex-wrap">
                    <!-- Resume Download Glass Button -->
                    @php
                        $hasActiveResume = \App\Models\Resume::where('is_active', true)->exists();
                    @endphp
                    @if($hasActiveResume)
                        <a href="{{ route('resume.download') }}" 
                           class="btn-glass btn-glass-resume" 
                           title="Download Rohit's Resume"
                           data-track="resume_download"
                           data-label="Navbar Download Resume">
                            <i class="bi bi-download"></i>
                            <span class="d-none d-sm-inline">Resume</span>
                        </a>
                    @endif

                    <!-- Light / Dark Glass Mode Toggle -->
                    <button type="button" 
                            id="themeToggleBtn" 
                            class="theme-toggle-btn" 
                            title="Toggle Theme" 
                            aria-label="Toggle theme">
                        <i class="bi bi-sun-fill"></i>
                    </button>

                    <!-- "Hire Me" Glass Button with Gradient Glow -->
                    <a href="{{ route('contact') }}" 
                       class="btn-glass btn-glass-primary"
                       data-track="hire_me_click"
                       data-label="Navbar Hire Me">
                        <span>Hire Me</span>
                        <i class="bi bi-arrow-right-short fs-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>
