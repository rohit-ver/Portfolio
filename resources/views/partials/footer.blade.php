<footer class="footer-glass" id="siteFooter">
    <div class="container">
        <div class="row gy-5 mb-5">

            <!-- Brand Column -->
            <div class="col-lg-4 col-md-6">
                <a class="brand-logo-badge text-decoration-none mb-4 d-inline-flex" href="{{ route('home') }}">
                    <div class="logo-icon-box" style="width:50px;height:50px;">
                        <span class="logo-text">RM</span>
                    </div>
                    <div class="d-flex flex-column ms-3">
                        <span class="brand-title">Rohit Verma</span>
                        <span class="brand-role">Laravel Artisan</span>
                    </div>
                </a>
                <p class="text-muted mb-4" style="font-size: 0.92rem; line-height: 1.7; max-width: 320px;">
                    {{ \App\Models\Setting::get('footer_tagline', 'Full Stack Web Developer passionate about crafting elegant, high-performance web systems with Laravel. Available for freelance and full-time opportunities.') }}
                </p>

                <!-- Social Links -->
                <div class="d-flex gap-2">
                    <a href="{{ \App\Models\Setting::get('social_github', 'https://github.com/rohitv3319') }}"
                       target="_blank" rel="noopener noreferrer"
                       class="btn-glass btn-glass-icon"
                       title="GitHub" aria-label="Visit Rohit's GitHub"
                       data-track="social_click"
                       data-label="GitHub">
                        <i class="bi bi-github"></i>
                    </a>
                    <a href="{{ \App\Models\Setting::get('social_linkedin', 'https://www.linkedin.com/in/rohit-verma') }}"
                       target="_blank" rel="noopener noreferrer"
                       class="btn-glass btn-glass-icon"
                       title="LinkedIn" aria-label="Visit Rohit's LinkedIn"
                       data-track="social_click"
                       data-label="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '916378156855') }}"
                       target="_blank" rel="noopener noreferrer"
                       class="btn-glass btn-glass-icon"
                       title="WhatsApp" aria-label="Chat on WhatsApp"
                       data-track="whatsapp_click"
                       data-label="Footer WhatsApp">
                        <i class="bi bi-whatsapp" style="color: #25D366;"></i>
                    </a>
                    <a href="mailto:{{ \App\Models\Setting::get('owner_email', 'rohitv3319@gmail.com') }}"
                       class="btn-glass btn-glass-icon"
                       title="Email" aria-label="Email Rohit"
                       data-track="email_click"
                       data-label="Footer Email">
                        <i class="bi bi-envelope-fill"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-3 col-6">
                <h6 class="text-uppercase mb-4" style="letter-spacing:.1em; font-size:.8rem; color: var(--accent); font-weight:700;">
                    Navigation
                </h6>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" class="text-muted text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1" style="font-size:.75rem;"></i>Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('experience') }}" class="text-muted text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1" style="font-size:.75rem;"></i>Experience
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('projects') }}" class="text-muted text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1" style="font-size:.75rem;"></i>Projects
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('contact') }}" class="text-muted text-decoration-none footer-link">
                            <i class="bi bi-chevron-right me-1" style="font-size:.75rem;"></i>Contact
                        </a>
                    </li>
                    @if(\App\Models\Resume::where('is_active', true)->exists())
                        <li class="mb-2">
                            <a href="{{ route('resume.download') }}" class="text-accent text-decoration-none footer-link" style="color: #34D399 !important;">
                                <i class="bi bi-download me-1" style="font-size:.75rem;"></i>Download CV
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Tech Stack -->
            <div class="col-lg-2 col-md-3 col-6">
                <h6 class="text-uppercase mb-4" style="letter-spacing:.1em; font-size:.8rem; color: var(--accent); font-weight:700;">
                    Technologies
                </h6>
                <ul class="list-unstyled footer-links">
                    @foreach(['Laravel', 'PHP 8.2+', 'MySQL', 'Bootstrap 5', 'JavaScript', 'REST APIs', 'Blade'] as $tech)
                        <li class="mb-2">
                            <span class="text-muted" style="font-size:0.9rem;">
                                <i class="bi bi-dot me-1" style="color: var(--primary);"></i>{{ $tech }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Contact Details -->
            <div class="col-lg-4 col-md-12">
                <h6 class="text-uppercase mb-4" style="letter-spacing:.1em; font-size:.8rem; color: var(--accent); font-weight:700;">
                    Get In Touch
                </h6>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-start gap-2">
                        <i class="bi bi-envelope-fill mt-1" style="color: var(--accent); font-size:1rem; flex-shrink:0;"></i>
                        <a href="mailto:{{ \App\Models\Setting::get('owner_email', 'rohitv3319@gmail.com') }}" 
                           class="text-muted text-decoration-none footer-link" 
                           style="word-break:break-all;"
                           data-track="email_click"
                           data-label="Footer Contact Email">
                            {{ \App\Models\Setting::get('owner_email', 'rohitv3319@gmail.com') }}
                        </a>
                    </li>
                    <li class="mb-3 d-flex align-items-start gap-2">
                        <i class="bi bi-telephone-fill mt-1" style="color: var(--accent); font-size:1rem; flex-shrink:0;"></i>
                        <a href="tel:{{ \App\Models\Setting::get('owner_phone', '+91 6378156855') }}" 
                           class="text-muted text-decoration-none footer-link"
                           data-track="call_click"
                           data-label="Footer Phone">
                            {{ \App\Models\Setting::get('owner_phone', '+91 6378156855') }}
                        </a>
                    </li>
                    <li class="mb-4 d-flex align-items-start gap-2">
                        <i class="bi bi-geo-alt-fill mt-1" style="color: var(--accent); font-size:1rem; flex-shrink:0;"></i>
                        <span class="text-muted" style="font-size:0.92rem;">{{ \App\Models\Setting::get('location', 'Rajasthan, India') }}</span>
                    </li>
                </ul>

                <!-- Resume Download CTA in Footer -->
                @if(\App\Models\Resume::where('is_active', true)->exists())
                    <div class="mb-3">
                        <a href="{{ route('resume.download') }}" 
                           class="btn-glass btn-glass-resume d-inline-flex" 
                           style="font-size:0.85rem; padding:0.5rem 1.2rem;"
                           data-track="resume_download"
                           data-label="Footer Download Resume">
                            <i class="bi bi-download"></i>
                            <span>Download Resume (PDF)</span>
                        </a>
                    </div>
                @endif

                <!-- Availability Badge -->
                <div class="glass-badge glass-badge-primary d-inline-flex">
                    <span class="status-dot"></span>
                    {{ \App\Models\Setting::get('availability_status', 'Available for New Projects') }}
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div style="height:1px; background: linear-gradient(to right, transparent, rgba(255,255,255,0.15), transparent); margin-bottom: 1.5rem;"></div>

        <!-- Bottom Row -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <p class="text-muted mb-0" style="font-size:0.875rem;">
                &copy; {{ date('Y') }} <strong style="color: var(--text-secondary);">Rohit Verma</strong>. All rights reserved.
            </p>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.login') }}" class="text-muted text-decoration-none footer-link" style="font-size:0.8rem;">
                    <i class="bi bi-shield-lock me-1"></i>Admin
                </a>
                <p class="text-muted mb-0" style="font-size:0.875rem;">
                    Crafted with <i class="bi bi-heart-fill" style="color:#EF4444;"></i> using
                    <span class="glass-badge glass-badge-primary" style="font-size:0.73rem; padding: 0.25rem 0.6rem;">Laravel</span>
                    &amp;
                    <span class="glass-badge glass-badge-accent" style="font-size:0.73rem; padding: 0.25rem 0.6rem;">Bootstrap 5</span>
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
.footer-link {
    font-size: 0.92rem;
    transition: color 0.25s ease;
}
.footer-link:hover {
    color: var(--accent) !important;
}
</style>
