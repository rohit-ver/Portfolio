@extends('layouts.app')

@section('title', 'Work Experience | Rohit Verma — Full Stack Web Developer')
@section('meta_description', 'Professional career and work experience of Rohit Verma as a Software Engineer at Pratham Software Pvt. Ltd. and past enterprise projects.')

@section('content')

<div style="padding: 3.5rem 0 6rem;">
    <div class="container">

        {{-- Page Header --}}
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-tag">Career Journey</span>
            <h1 class="section-title">Work Experience</h1>
            <p class="section-subtitle mx-auto">        
                My journey as a freelance web developer, building responsive websites and dynamic web applications using PHP and Laravel, while combining technical expertise with business understanding to deliver practical, user-friendly solutions that help businesses grow online.
            </p>
        </div>

        {{-- Experience Timeline --}}
        <div class="timeline-container">
            @forelse($experiences as $exp)
                <div class="timeline-item {{ $loop->iteration % 2 == 1 ? 'timeline-left' : 'timeline-right' }}" data-aos="fade-up" data-aos-duration="900">
                    
                    <!-- Timeline Glowing Dot -->
                    <div class="timeline-dot {{ $exp->is_current ? 'current' : '' }}" title="{{ $exp->is_current ? 'Currently Working' : 'Completed' }}"></div>

                    <!-- Timeline Card -->
                    <div class="glass timeline-content-card">
                        
                        <!-- Top Header: Role & Status -->
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                            <div>
                                <span class="role-badge d-block mb-1">{{ $exp->designation }}</span>
                                <h2 class="company-title mb-0">{{ $exp->company }}</h2>
                            </div>

                            <div>
                                @if($exp->is_current)
                                    <span class="glass-badge glass-badge-success">
                                        <span class="status-dot" style="width:6px;height:6px;"></span>
                                        Currently Working
                                    </span>
                                @else
                                    <span class="glass-badge">
                                        <i class="bi bi-check2-circle"></i> Completed
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Meta Info: Duration, Location, Type -->
                        <div class="d-flex flex-wrap align-items-center gap-3 text-muted mb-4" style="font-size: 0.88rem;">
                            <span>
                                <i class="bi bi-calendar3 me-1" style="color: var(--accent);"></i>
                                {{ $exp->start_date->format('F Y') }} – {{ $exp->is_current ? 'Present' : ($exp->end_date ? $exp->end_date->format('F Y') : 'Present') }}
                            </span>
                            @if($exp->location)
                                <span>
                                    <i class="bi bi-geo-alt me-1" style="color: var(--accent);"></i>
                                    {{ $exp->location }}
                                </span>
                            @endif
                            <span>
                                <i class="bi bi-briefcase me-1" style="color: var(--accent);"></i>
                                {{ $exp->type }}
                            </span>
                        </div>

                        <!-- Company / Role Description -->
                        @if($exp->description)
                            <p class="mb-4" style="color: var(--text-secondary); line-height: 1.75; font-size: 0.96rem;">
                                {{ $exp->description }}
                            </p>
                        @endif

                        <!-- Key Responsibilities List -->
                        @if(!empty($exp->responsibilities) && is_array($exp->responsibilities))
                            <h3 class="font-heading mb-3" style="font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--accent);">
                                Key Responsibilities &amp; Impact
                            </h3>
                            <ul class="list-unstyled mb-4">
                                @foreach($exp->responsibilities as $resp)
                                    <li class="d-flex align-items-start gap-2 mb-2" style="color: var(--text-secondary); font-size: 0.93rem; line-height: 1.65;">
                                        <i class="bi bi-arrow-right-short fs-5 flex-shrink-0" style="color: var(--accent); margin-top: -2px;"></i>
                                        <span>{{ $resp }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <!-- Tech Stack Pills -->
                        @if(!empty($exp->tech_stack) && is_array($exp->tech_stack))
                            <div class="d-flex flex-wrap gap-2 pt-2" style="border-top: 1px solid rgba(255, 255, 255, 0.08);">
                                @foreach($exp->tech_stack as $tech)
                                    <span class="glass-badge" style="font-size: 0.76rem;">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="glass p-5 mx-auto" style="max-width: 500px;">
                        <i class="bi bi-briefcase text-muted fs-1 mb-3 d-block"></i>
                        <h4 class="mb-2">No Experience Entries Found</h4>
                        <p class="text-muted">Experience details can be managed via the admin panel.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Bottom Action CTA -->
        <div class="text-center mt-5" data-aos="zoom-in">
            <div class="glass p-4 d-inline-flex flex-wrap align-items-center justify-content-center gap-3">
                <span style="font-weight: 500;">Interested in my background and experience?</span>
                @if(\App\Models\Resume::where('is_active', true)->exists())
                    <a href="{{ route('resume.download') }}" class="btn-glass btn-glass-resume">
                        <i class="bi bi-download"></i>
                        <span>Download Resume</span>
                    </a>
                @endif
                <a href="{{ route('contact') }}" class="btn-glass btn-glass-primary">
                    <i class="bi bi-chat-dots-fill"></i>
                    <span>Contact Me</span>
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
