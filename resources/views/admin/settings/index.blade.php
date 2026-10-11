@extends('admin.layout')

@section('title', 'Site Settings')
@section('page_title', 'Site & Hero Settings')
@section('page_subtitle', 'Configure hero profile image, designation, social links, contact info, and SEO')

@section('content')

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        <!-- Hero Section & Profile Card (Requirement 2) -->
        <div class="col-lg-6">
            <div class="glass p-4 h-100">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-person-badge fs-4" style="color: var(--accent);"></i>
                    <h5 class="font-heading mb-0">Hero &amp; Profile Card</h5>
                </div>

                <!-- Profile Image Preview & Upload -->
                <div class="mb-4">
                    <label class="form-label d-block">Hero Profile Image</label>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="hero-avatar-wrapper m-0" style="width: 100px; height: 100px;">
                            <img src="{{ !empty($settings['profile_image']) ? asset($settings['profile_image']) : asset('images/profile-placeholder.png') }}" 
                                 alt="Profile Preview" 
                                 id="profilePreview"
                                 class="hero-avatar-img"
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 onerror="this.src='{{ asset('images/profile-placeholder.png') }}'">
                        </div>
                        <div>
                            <input type="file" 
                                   name="profile_image_file" 
                                   id="profileImageInput" 
                                   class="form-control form-control-sm mb-1" 
                                   accept="image/jpeg,image/png,image/webp">
                            <small class="text-muted d-block">Recommended: Square JPG, PNG or WEBP (max 2 MB).</small>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="designation" class="form-label">Professional Designation</label>
                    <input type="text" 
                           name="designation" 
                           id="designation" 
                           class="form-control" 
                           value="{{ old('designation', $settings['designation'] ?? 'Full Stack Web Developer (Laravel / PHP)') }}" 
                           required>
                    <small class="text-muted">Appears in Hero Profile card, typing text, and metadata.</small>
                </div>

                <div class="mb-3">
                    <label for="hero_name" class="form-label">Hero Display Name</label>
                    <input type="text" 
                           name="hero_name" 
                           id="hero_name" 
                           class="form-control" 
                           value="{{ old('hero_name', $settings['hero_name'] ?? 'Rohit Verma') }}" 
                           required>
                </div>

                <div class="mb-3">
                    <label for="hero_bio" class="form-label">Hero Bio / Pitch</label>
                    <textarea name="hero_bio" 
                              id="hero_bio" 
                              rows="3" 
                              class="form-control">{{ old('hero_bio', $settings['hero_bio'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Contact & Location Info -->
        <div class="col-lg-6">
            <div class="glass p-4 h-100">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-geo-alt fs-4" style="color: var(--primary-light);"></i>
                    <h5 class="font-heading mb-0">Contact &amp; Location Details</h5>
                </div>

                <div class="mb-3">
                    <label for="owner_email" class="form-label">Notification &amp; Display Email</label>
                    <input type="email" 
                           name="owner_email" 
                           id="owner_email" 
                           class="form-control" 
                           value="{{ old('owner_email', $settings['owner_email'] ?? 'rohitv3319@gmail.com') }}" 
                           required>
                </div>

                <div class="mb-3">
                    <label for="owner_phone" class="form-label">Phone Number</label>
                    <input type="text" 
                           name="owner_phone" 
                           id="owner_phone" 
                           class="form-control" 
                           value="{{ old('owner_phone', $settings['owner_phone'] ?? '+91 6378156855') }}">
                </div>

                <div class="mb-3">
                    <label for="whatsapp_number" class="form-label">WhatsApp Number (with country code, no +)</label>
                    <input type="text" 
                           name="whatsapp_number" 
                           id="whatsapp_number" 
                           class="form-control" 
                           value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '916378156855') }}">
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" 
                           name="location" 
                           id="location" 
                           class="form-control" 
                           value="{{ old('location', $settings['location'] ?? 'Rajasthan, India') }}">
                </div>

                <div class="mb-3">
                    <label for="availability_status" class="form-label">Availability Status Text</label>
                    <input type="text" 
                           name="availability_status" 
                           id="availability_status" 
                           class="form-control" 
                           value="{{ old('availability_status', $settings['availability_status'] ?? 'Available for Full-time Roles & High-Impact Freelance Projects') }}">
                </div>
            </div>
        </div>

        <!-- Social Media Links -->
        <div class="col-lg-6">
            <div class="glass p-4 h-100">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-share fs-4" style="color: #10B981;"></i>
                    <h5 class="font-heading mb-0">Social Links</h5>
                </div>

                <div class="mb-3">
                    <label for="social_github" class="form-label"><i class="bi bi-github me-1"></i> GitHub URL</label>
                    <input type="url" 
                           name="social_github" 
                           id="social_github" 
                           class="form-control" 
                           value="{{ old('social_github', $settings['social_github'] ?? 'https://github.com/rohitv3319') }}">
                </div>

                <div class="mb-3">
                    <label for="social_linkedin" class="form-label"><i class="bi bi-linkedin me-1 text-primary"></i> LinkedIn URL</label>
                    <input type="url" 
                           name="social_linkedin" 
                           id="social_linkedin" 
                           class="form-control" 
                           value="{{ old('social_linkedin', $settings['social_linkedin'] ?? 'https://www.linkedin.com/in/rohit-verma') }}">
                </div>
            </div>
        </div>

        <!-- SEO & Footer -->
        <div class="col-lg-6">
            <div class="glass p-4 h-100">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-search fs-4" style="color: #F59E0B;"></i>
                    <h5 class="font-heading mb-0">SEO &amp; Footer Branding</h5>
                </div>

                <div class="mb-3">
                    <label for="meta_title" class="form-label">SEO Meta Title</label>
                    <input type="text" 
                           name="meta_title" 
                           id="meta_title" 
                           class="form-control" 
                           value="{{ old('meta_title', $settings['meta_title'] ?? 'Rohit Verma | Full Stack Web Developer (Laravel / PHP)') }}">
                </div>

                <div class="mb-3">
                    <label for="meta_description" class="form-label">SEO Meta Description</label>
                    <textarea name="meta_description" 
                              id="meta_description" 
                              rows="2" 
                              class="form-control">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="footer_tagline" class="form-label">Footer Tagline</label>
                    <input type="text" 
                           name="footer_tagline" 
                           id="footer_tagline" 
                           class="form-control" 
                           value="{{ old('footer_tagline', $settings['footer_tagline'] ?? 'Crafting high-performance, elegant web systems with Laravel & modern frontend technologies.') }}">
                </div>

                <div class="row g-2 pt-2" style="border-top: 1px solid rgba(255, 255, 255, 0.08);">
                    <div class="col-md-6 mb-2">
                        <label for="ga4_measurement_id" class="form-label text-muted" style="font-size: 0.85rem;">Google Analytics 4 ID</label>
                        <input type="text" 
                               name="ga4_measurement_id" 
                               id="ga4_measurement_id" 
                               class="form-control form-control-sm" 
                               placeholder="G-XXXXXXXXXX" 
                               value="{{ old('ga4_measurement_id', $settings['ga4_measurement_id'] ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="clarity_project_id" class="form-label text-muted" style="font-size: 0.85rem;">Microsoft Clarity ID</label>
                        <input type="text" 
                               name="clarity_project_id" 
                               id="clarity_project_id" 
                               class="form-control form-control-sm" 
                               placeholder="e.g. abc123xyz" 
                               value="{{ old('clarity_project_id', $settings['clarity_project_id'] ?? '') }}">
                    </div>
                    <small class="text-muted d-block" style="font-size: 0.78rem;">
                        Note: Third-party scripts are only injected in production environments (<code>APP_ENV=production</code>).
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 text-end">
        <button type="submit" class="btn-glass btn-glass-primary px-4 py-2 fs-6">
            <i class="bi bi-save-fill"></i>
            <span>Save All Settings</span>
        </button>
    </div>
</form>

@endsection

@push('scripts')
<script>
document.getElementById('profileImageInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(evt) {
            document.getElementById('profilePreview').src = evt.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
