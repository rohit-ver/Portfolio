@extends('admin.layout')

@section('title', 'View Message')
@section('page_title', 'Inquiry Message')
@section('page_subtitle', 'From ' . $contact->name)

@section('page_actions')
    <a href="{{ route('admin.contacts.index') }}" class="btn-glass py-1 px-3" style="font-size: 0.85rem;">
        &larr; Back to Inbox
    </a>
    <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}" class="btn-glass btn-glass-primary py-1 px-3" style="font-size: 0.85rem;">
        <i class="bi bi-reply-fill"></i> Reply via Email
    </a>
@endsection

@section('content')

<div class="glass p-4" style="max-width: 800px; margin: 0 auto;">
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4" style="border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
        <div>
            <h4 class="font-heading mb-1" style="font-size: 1.25rem;">{{ $contact->subject }}</h4>
            <div class="text-muted" style="font-size: 0.88rem;">
                From: <strong style="color: var(--text-main);">{{ $contact->name }}</strong>
                &bull; <a href="mailto:{{ $contact->email }}" class="text-accent text-decoration-none">{{ $contact->email }}</a>
            </div>
        </div>
        <div class="text-end">
            <span class="text-muted d-block" style="font-size: 0.85rem;">{{ $contact->created_at->format('M d, Y - h:i A') }}</span>
            <small class="text-muted">IP: {{ $contact->ip_address ?? 'N/A' }}</small>
        </div>
    </div>

    <div class="p-4 rounded mb-4" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08); font-size: 1rem; line-height: 1.7; white-space: pre-wrap; color: var(--text-main);">
{{ $contact->message }}
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-trash"></i> Delete Message
            </button>
        </form>

        <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}" class="btn-glass btn-glass-primary">
            <i class="bi bi-reply-fill"></i> Reply to {{ $contact->name }}
        </a>
    </div>
</div>

@endsection
