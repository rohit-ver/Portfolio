@extends('admin.layout')

@section('title', 'Admin Profile & Security')
@section('page_title', 'Profile & Password')
@section('page_subtitle', 'Manage admin credentials and authentication security')

@section('content')

<div class="glass p-4" style="max-width: 680px; margin: 0 auto;">
    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf

        <h5 class="font-heading mb-3">Admin Account Details</h5>

        <div class="mb-3">
            <label for="name" class="form-label">Admin Name *</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-4">
            <label for="email" class="form-label">Email Address *</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <h5 class="font-heading mb-3 pt-3" style="border-top: 1px solid rgba(255, 255, 255, 0.1);">Change Password</h5>
        <p class="text-muted" style="font-size: 0.88rem;">Leave blank if you do not wish to change your password.</p>

        <div class="mb-3">
            <label for="current_password" class="form-label">Current Password</label>
            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="••••••••••••">
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label for="new_password" class="form-label">New Password (min 8 chars)</label>
                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="••••••••••••">
            </div>
            <div class="col-md-6">
                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" placeholder="••••••••••••">
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn-glass btn-glass-primary px-4 py-2">
                <i class="bi bi-shield-check"></i> Update Credentials
            </button>
        </div>
    </form>
</div>

@endsection
