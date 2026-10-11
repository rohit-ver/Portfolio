<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'Rohit Verma | Full Stack Web Developer (Laravel / PHP)')</title>
    <meta name="description" content="@yield('meta_description', 'Official portfolio of Rohit Verma, a Senior Full Stack Web Developer specializing in Laravel, PHP, MySQL, REST APIs, and modern responsive frontend design.')">
    <meta name="keywords" content="Rohit Verma, Laravel Developer, PHP Developer, Full Stack Web Developer, Web Artisan, Portfolio, MySQL, Bootstrap 5, Web Development, India">
    <meta name="author" content="Rohit Verma">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Rohit Verma | Full Stack Web Developer (Laravel / PHP)')">
    <meta property="og:description" content="@yield('meta_description', 'Senior Full Stack Web Developer specializing in Laravel, PHP, and high-performance web systems.')">
    <meta property="og:image" content="{{ asset('images/avatar.svg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Rohit Verma | Full Stack Web Developer (Laravel / PHP)')">
    <meta property="twitter:description" content="@yield('meta_description', 'Senior Full Stack Web Developer specializing in Laravel, PHP, and high-performance web systems.')">
    <meta property="twitter:image" content="{{ asset('images/avatar.svg') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">

    <!-- Google Fonts: Poppins (Headings) & Inter (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- AOS (Animate On Scroll) CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Glassmorphism Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Third-Party Analytics (Production Only) -->
    @if(app()->environment('production'))
        @php
            $ga4Id = \App\Models\Setting::get('ga4_measurement_id');
            $clarityId = \App\Models\Setting::get('clarity_project_id');
        @endphp

        @if(!empty($ga4Id))
            <!-- Google Analytics 4 -->
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4Id }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '{{ $ga4Id }}');
            </script>
        @endif

        @if(!empty($clarityId))
            <!-- Microsoft Clarity -->
            <script type="text/javascript">
                (function(c,l,a,r,i,t,y){
                    c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
                    t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
                    y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
                })(window, document, "clarity", "script", "{{ $clarityId }}");
            </script>
        @endif
    @endif

    @stack('styles')
</head>
<body>

    <!-- Ambient Animated Background with Floating Frosted Blobs -->
    <div class="ambient-background" aria-hidden="true">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
        <div class="blob blob-4"></div>
    </div>

    <!-- Sticky Floating Glass Navbar -->
    @include('partials.navbar')

    <!-- Flash Alerts (Success / Error) -->
    <div class="container">
        @include('partials.alerts')
    </div>

    <!-- Main Page Content -->
    <main id="main-content">
        @yield('content')
    </main>

    <!-- Glass Footer -->
    @include('partials.footer')

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/916378156855?text=Hi%20Rohit,%20I%20would%20like%20to%20discuss%20a%20web%20development%20project." 
       target="_blank" 
       rel="noopener noreferrer" 
       class="whatsapp-float-btn" 
       title="Chat with Rohit on WhatsApp"
       aria-label="Chat on WhatsApp"
       data-track="whatsapp_click"
       data-label="Floating WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>

    <!-- Scroll To Top Button -->
    <button type="button" 
            id="scrollTopBtn" 
            class="scroll-top-btn" 
            title="Scroll back to top" 
            aria-label="Scroll to top">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Privacy & Cookie Notice Banner -->
    <div id="cookiePrivacyBanner" 
         class="glass position-fixed bottom-0 start-50 translate-middle-x mb-4 px-4 py-3 d-none align-items-center justify-content-between gap-3 shadow-lg" 
         style="z-index: 1060; max-width: 600px; width: 92%; border-radius: 16px;">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-shield-check text-accent fs-4" style="color: var(--accent);"></i>
            <small class="text-muted" style="font-size: 0.85rem; line-height: 1.4;">
                This site uses privacy-friendly anonymous analytics with hashed IPs to improve your experience. No personal profiling.
            </small>
        </div>
        <button type="button" id="acceptCookiesBtn" class="btn-glass btn-glass-primary py-1 px-3 text-nowrap" style="font-size: 0.82rem;">
            OK, Got it
        </button>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Main Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>

    @stack('scripts')
</body>
</html>
