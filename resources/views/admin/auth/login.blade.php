<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login &bull; Rohit Verma Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem 1rem;
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            padding: 3rem 2.2rem;
            border-radius: 24px;
        }
    </style>
</head>
<body>

    <div class="ambient-background" aria-hidden="true">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <div class="glass-card login-card" data-aos="zoom-in">
        <div class="text-center mb-4">
            <div class="logo-icon-box mx-auto mb-3" style="width: 52px; height: 52px;">
                <span class="logo-text fs-4">RM</span>
            </div>
            <h1 class="h3 font-heading mb-1">Admin Portal</h1>
            <p class="text-muted" style="font-size: 0.9rem;">Sign in to manage your portfolio</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-transparent border-success text-success mb-3 p-2 text-center" style="font-size: 0.88rem;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger bg-transparent border-danger text-danger mb-3 p-2 text-center" style="font-size: 0.88rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label" style="font-size: 0.88rem;">Admin Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--input-border); color: var(--accent);">
                        <i class="bi bi-envelope-fill"></i>
                    </span>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           class="form-control border-start-0 ps-0" 
                           value="{{ old('email', 'rohitv3319@gmail.com') }}" 
                           required 
                           autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label" style="font-size: 0.88rem;">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--input-border); color: var(--accent);">
                        <i class="bi bi-key-fill"></i>
                    </span>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="form-control border-start-0 ps-0" 
                           placeholder="••••••••••••" 
                           required>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                    <label class="form-check-label text-muted" for="remember" style="font-size: 0.85rem;">
                        Remember me
                    </label>
                </div>
                <a href="{{ route('home') }}" class="text-muted text-decoration-none" style="font-size: 0.85rem;">
                    &larr; Back to site
                </a>
            </div>

            <button type="submit" class="btn-glass btn-glass-primary w-100 justify-content-center py-2 fs-6">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Sign In to Dashboard</span>
            </button>
        </form>
    </div>

</body>
</html>
