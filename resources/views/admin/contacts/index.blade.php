@extends('admin.layout')

@section('title', 'Messages Inbox')
@section('page_title', 'Contact Messages')
@section('page_subtitle', 'Inquiries received via the contact form')

@section('content')

<div class="glass p-4">
    @if($messages->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-inbox text-muted fs-1 mb-3 d-block"></i>
            <h5>No Messages Yet</h5>
            <p class="text-muted">Inquiries sent via the public contact form will appear here.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="text-muted" style="font-size: 0.85rem;">
                        <th>Sender</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $msg)
                        <tr class="{{ !$msg->is_read ? 'table-active' : '' }}">
                            <td>
                                <strong style="color: var(--text-main);">{{ $msg->name }}</strong>
                                <small class="text-muted d-block">{{ $msg->email }}</small>
                            </td>
                            <td>
                                <a href="{{ route('admin.contacts.show', $msg) }}" class="text-decoration-none" style="color: var(--text-main); font-weight: {{ !$msg->is_read ? '600' : '400' }};">
                                    {{ Str::limit($msg->subject, 50) }}
                                </a>
                            </td>
                            <td>{{ $msg->created_at->format('M d, Y - h:i A') }}</td>
                            <td>
                                @if(!$msg->is_read)
                                    <span class="badge bg-primary">Unread</span>
                                @else
                                    <span class="badge bg-secondary">Read</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.contacts.show', $msg) }}" class="btn btn-sm btn-outline-info" title="View Message">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.contacts.destroy', $msg) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $messages->links() }}
        </div>
    @endif
</div>

@endsection
