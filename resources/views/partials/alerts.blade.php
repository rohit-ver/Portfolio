@if (session('success'))
    <div class="glass-alert glass-alert-success d-flex align-items-start gap-3 mt-3" role="alert">
        <i class="bi bi-check-circle-fill text-success fs-4 flex-shrink-0 mt-1"></i>
        <div class="flex-grow-1">
            <strong class="d-block mb-1" style="color: #34D399;">Message Sent!</strong>
            <span style="color: #CBD5E1;">{{ session('success') }}</span>
        </div>
        <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="glass-alert glass-alert-danger d-flex align-items-start gap-3 mt-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill text-danger fs-4 flex-shrink-0 mt-1"></i>
        <div class="flex-grow-1">
            <strong class="d-block mb-1" style="color: #F87171;">Submission Error</strong>
            <span style="color: #CBD5E1;">{{ session('error') }}</span>
        </div>
        <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
