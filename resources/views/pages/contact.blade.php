@extends('layouts.app')

@section('title', 'Contact Me | Rohit Verma — Laravel Web Developer')
@section('meta_description', 'Get in touch with Rohit Verma for your web development projects. Fill out the contact form or reach out directly via email, phone or WhatsApp.')

@section('content')

<div style="padding: 3.5rem 0 6rem;">
    <div class="container">

        {{-- Page Header --}}
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-tag">Reach Out</span>
            <h1 class="section-title">Let's Work Together</h1>
            <p class="section-subtitle mx-auto">
                Got a project idea, a question, or just want to say hello?
                I typically respond within <strong style="color:var(--accent);">24 hours</strong>.
            </p>
        </div>

        <div class="row g-5 align-items-start">

            {{-- LEFT: Contact Form --}}
            <div class="col-lg-7" data-aos="fade-right" data-aos-duration="800">
                <div class="glass p-4 p-md-5" style="border-radius: 24px;">

                    <h3 class="font-heading mb-1" style="font-size:1.4rem;">Send a Message</h3>
                    <p class="text-muted mb-4" style="font-size:.92rem;">
                        All fields are required. Your details are kept completely private.
                    </p>

                    <form action="{{ route('contact.store') }}"
                          method="POST"
                          id="portfolioContactForm"
                          novalidate>
                        @csrf

                        {{-- Name --}}
                        <div class="mb-4">
                            <label for="contact_name" class="form-label d-flex align-items-center gap-2" style="color:var(--text-secondary); font-size:.9rem; font-weight:600;">
                                <i class="bi bi-person-fill" style="color:var(--accent);"></i> Your Name
                            </label>
                            <input type="text"
                                   name="name"
                                   id="contact_name"
                                   class="form-control glass-input @error('name') is-invalid @enderror"
                                   placeholder="e.g. Arjun Sharma"
                                   value="{{ old('name') }}"
                                   autocomplete="name"
                                   required>
                            @error('name')
                                <div class="invalid-feedback d-block mt-1" style="color:#F87171; font-size:.83rem;">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="contact_email" class="form-label d-flex align-items-center gap-2" style="color:var(--text-secondary); font-size:.9rem; font-weight:600;">
                                <i class="bi bi-envelope-fill" style="color:var(--accent);"></i> Email Address
                            </label>
                            <input type="email"
                                   name="email"
                                   id="contact_email"
                                   class="form-control glass-input @error('email') is-invalid @enderror"
                                   placeholder="e.g. arjun@yourcompany.com"
                                   value="{{ old('email') }}"
                                   autocomplete="email"
                                   required>
                            @error('email')
                                <div class="invalid-feedback d-block mt-1" style="color:#F87171; font-size:.83rem;">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Subject --}}
                        <div class="mb-4">
                            <label for="contact_subject" class="form-label d-flex align-items-center gap-2" style="color:var(--text-secondary); font-size:.9rem; font-weight:600;">
                                <i class="bi bi-chat-left-text-fill" style="color:var(--accent);"></i> Subject
                            </label>
                            <input type="text"
                                   name="subject"
                                   id="contact_subject"
                                   class="form-control glass-input @error('subject') is-invalid @enderror"
                                   placeholder="e.g. New Laravel E-commerce Project"
                                   value="{{ old('subject') }}"
                                   required>
                            @error('subject')
                                <div class="invalid-feedback d-block mt-1" style="color:#F87171; font-size:.83rem;">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Message --}}
                        <div class="mb-5">
                            <label for="contact_message" class="form-label d-flex align-items-center gap-2" style="color:var(--text-secondary); font-size:.9rem; font-weight:600;">
                                <i class="bi bi-pencil-fill" style="color:var(--accent);"></i> Message
                            </label>
                            <textarea name="message"
                                      id="contact_message"
                                      rows="6"
                                      class="form-control glass-input @error('message') is-invalid @enderror"
                                      placeholder="Describe your project, timeline, budget, and any requirements you'd like to discuss..."
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback d-block mt-1" style="color:#F87171; font-size:.83rem;">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" 
                                class="btn-glass btn-glass-primary w-100 justify-content-center" 
                                style="padding:.9rem 2rem; font-size:1rem;"
                                data-track="contact_form_submit"
                                data-label="Contact Page Form">
                            <i class="bi bi-send-fill"></i>
                            <span>Send Message</span>
                        </button>

                        <p class="text-center text-muted mt-3" style="font-size:.8rem;">
                            <i class="bi bi-shield-lock me-1" style="color:var(--accent);"></i>
                            Your information is 100% secure and will never be shared with third parties.
                        </p>
                    </form>
                </div>
            </div>

            {{-- RIGHT: Contact Info + Social --}}
            <div class="col-lg-5" data-aos="fade-left" data-aos-duration="800" data-aos-delay="150">

                {{-- Contact Info Cards --}}
                <div class="glass contact-info-card" style="margin-bottom:1.25rem;">
                    <div class="contact-info-icon">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div>
                        <div class="contact-info-title">Email Address</div>
                        <a href="mailto:{{ $contactInfo['email'] }}" 
                           class="contact-info-val text-decoration-none" 
                           style="color:var(--text-primary);"
                           data-track="email_click"
                           data-label="Contact Page Email">
                            {{ $contactInfo['email'] }}
                        </a>
                        <p class="text-muted mb-0 mt-1" style="font-size:.8rem;">Click to send a direct email</p>
                    </div>
                </div>

                <div class="glass contact-info-card" style="margin-bottom:1.25rem;">
                    <div class="contact-info-icon">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div>
                        <div class="contact-info-title">Phone / WhatsApp</div>
                        <a href="tel:+916378156855" 
                           class="contact-info-val text-decoration-none" 
                           style="color:var(--text-primary);"
                           data-track="call_click"
                           data-label="Contact Page Phone">
                            {{ $contactInfo['phone'] }}
                        </a>
                        <p class="text-muted mb-0 mt-1" style="font-size:.8rem;">
                            <a href="https://wa.me/916378156855" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               style="color:#25D366; text-decoration:none;"
                               data-track="whatsapp_click"
                               data-label="Contact Page WhatsApp">
                                <i class="bi bi-whatsapp me-1"></i> Chat on WhatsApp
                            </a>
                        </p>
                    </div>
                </div>

                <div class="glass contact-info-card" style="margin-bottom:1.25rem;">
                    <div class="contact-info-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <div class="contact-info-title">Location</div>
                        <span class="contact-info-val">{{ $contactInfo['location'] }}</span>
                        <p class="text-muted mb-0 mt-1" style="font-size:.8rem;">Open to remote collaboration worldwide</p>
                    </div>
                </div>

                <div class="glass contact-info-card" style="margin-bottom:1.75rem;">
                    <div class="contact-info-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <div class="contact-info-title">Availability</div>
                        <span class="contact-info-val" style="font-size:.98rem;">{{ $contactInfo['availability'] }}</span>
                        <div class="mt-2">
                            <span class="glass-badge" style="font-size:.72rem;">
                                <span class="status-dot" style="width:6px;height:6px;"></span>
                                Typically responds in &lt; 24 hours
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Social Links --}}
                <div class="glass p-4" style="border-radius:20px;">
                    <h5 class="font-heading mb-3" style="font-size:1rem; color:var(--text-secondary);">Connect on Social</h5>
                    <div class="d-flex gap-3">
                        <a href="https://github.com/rohit-ver" target="_blank" rel="noopener noreferrer"
                           class="btn-glass btn-glass-icon d-flex flex-column align-items-center"
                           style="width:auto; height:auto; padding:.7rem 1.1rem; border-radius:14px; gap:.3rem; font-size:.72rem;"
                           title="GitHub">
                            <i class="bi bi-github" style="font-size:1.3rem;"></i>
                            GitHub
                        </a>
                        <a href="https://www.linkedin.com/in/rohit-verma-94633b275/" target="_blank" rel="noopener noreferrer"
                           class="btn-glass btn-glass-icon d-flex flex-column align-items-center"
                           style="width:auto; height:auto; padding:.7rem 1.1rem; border-radius:14px; gap:.3rem; font-size:.72rem; color:#60A5FA;"
                           title="LinkedIn">
                            <i class="bi bi-linkedin" style="font-size:1.3rem;"></i>
                            LinkedIn
                        </a>
                        <a href="https://wa.me/916378156855" target="_blank" rel="noopener noreferrer"
                           class="btn-glass btn-glass-icon d-flex flex-column align-items-center"
                           style="width:auto; height:auto; padding:.7rem 1.1rem; border-radius:14px; gap:.3rem; font-size:.72rem; color:#25D366;"
                           title="WhatsApp">
                            <i class="bi bi-whatsapp" style="font-size:1.3rem;"></i>
                            WhatsApp
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
