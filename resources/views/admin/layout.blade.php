<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') &bull; Rohit Verma Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
</head>
<body>

    <div class="ambient-background" aria-hidden="true">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                <div class="logo-icon-box" style="width: 40px; height: 40px;">
                    <span class="logo-text fs-5">RM</span>
                </div>
                <div>
                    <h6 class="font-heading mb-0" style="font-size: 0.95rem;">Rohit Verma</h6>
                    <small class="text-muted" style="font-size: 0.75rem;">Admin Panel</small>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-grow-1">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('admin.analytics.index') }}" class="admin-nav-item {{ request()->routeIs('admin.analytics*') ? 'active' : '' }}">
                    <i class="bi bi-graph-up-arrow"></i> Analytics
                </a>
                <a href="{{ route('admin.projects.index') }}" class="admin-nav-item {{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
                    <i class="bi bi-code-slash"></i> Projects
                </a>
                <a href="{{ route('admin.skills.index') }}" class="admin-nav-item {{ request()->routeIs('admin.skills*') ? 'active' : '' }}">
                    <i class="bi bi-tools"></i> Skills
                </a>
                <a href="{{ route('admin.experiences.index') }}" class="admin-nav-item {{ request()->routeIs('admin.experiences*') ? 'active' : '' }}">
                    <i class="bi bi-briefcase"></i> Experience
                </a>
                <a href="{{ route('admin.resume.index') }}" class="admin-nav-item {{ request()->routeIs('admin.resume*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-pdf"></i> Resume Manager
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="admin-nav-item {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}">
                    <i class="bi bi-chat-left-dots"></i> Messages
                    @php
                        $unreadCount = \App\Models\Contact::where('is_read', false)->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="badge bg-danger rounded-pill ms-auto">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.settings.index') }}" class="admin-nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    <i class="bi bi-sliders"></i> Site Settings
                </a>
                <a href="{{ route('admin.profile') }}" class="admin-nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i> Profile &amp; Password
                </a>
            </nav>

            <!-- Bottom Actions -->
            <div class="pt-3" style="border-top: 1px solid rgba(255, 255, 255, 0.1);">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ route('home') }}" target="_blank" class="text-muted text-decoration-none d-flex align-items-center gap-1" style="font-size: 0.85rem;">
                        <i class="bi bi-box-arrow-up-right"></i> View Site
                    </a>
                    <button type="button" id="themeToggleBtn" class="theme-toggle-btn" title="Toggle Theme" style="width: 34px; height: 34px;">
                        <i class="bi bi-sun-fill"></i>
                    </button>
                </div>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-glass w-100 justify-content-center text-danger py-1" style="font-size: 0.85rem; border-color: rgba(239, 68, 68, 0.3);">
                        <i class="bi bi-box-arrow-right"></i> Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-content">
            <!-- Header bar -->
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-3" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                <div>
                    <h2 class="h4 font-heading mb-0">@yield('page_title', 'Dashboard')</h2>
                    <small class="text-muted">@yield('page_subtitle', 'Overview & quick portfolio stats')</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    @yield('page_actions')
                </div>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="glass-alert glass-alert-success d-flex align-items-center gap-2 mb-4 p-3" role="alert">
                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="glass-alert glass-alert-danger d-flex align-items-center gap-2 mb-4 p-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="glass-alert glass-alert-danger mb-4 p-3" role="alert">
                    <strong class="d-block mb-1">Please fix the following errors:</strong>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
