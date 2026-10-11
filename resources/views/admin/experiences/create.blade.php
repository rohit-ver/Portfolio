@extends('admin.layout')

@section('title', 'Add Experience')
@section('page_title', 'Add New Experience')
@section('page_subtitle', 'Add a job role or company to your career timeline')

@section('page_actions')
    <a href="{{ route('admin.experiences.index') }}" class="btn-glass py-1 px-3" style="font-size: 0.85rem;">
        &larr; Back to List
    </a>
@endsection

@section('content')

<div class="glass p-4" style="max-width: 800px; margin: 0 auto;">
    <form action="{{ route('admin.experiences.store') }}" method="POST">
        @csrf

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="company" class="form-label">Company Name *</label>
                <input type="text" name="company" id="company" class="form-control" value="{{ old('company') }}" required>
            </div>
            <div class="col-md-6">
                <label for="designation" class="form-label">Designation / Role *</label>
                <input type="text" name="designation" id="designation" class="form-control" value="{{ old('designation') }}" required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" placeholder="e.g. Jaipur, India">
            </div>
            <div class="col-md-6">
                <label for="type" class="form-label">Employment Type *</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="Full-time" {{ old('type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="Part-time" {{ old('type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="Contract" {{ old('type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                    <option value="Freelance" {{ old('type') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                </select>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-5">
                <label for="start_date" class="form-label">Start Date *</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
            </div>
            <div class="col-md-5" id="endDateCol">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end pb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_current" id="is_current" value="1" {{ old('is_current') ? 'checked' : '' }}>
                    <label class="form-check-label text-nowrap" for="is_current" style="font-size: 0.85rem;">
                        Current Job
                    </label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Company Overview / Context</label>
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Brief note about the company and products...">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="responsibilities" class="form-label">Key Responsibilities (one per line)</label>
            <textarea name="responsibilities" id="responsibilities" rows="4" class="form-control" placeholder="Architected core Laravel REST APIs&#10;Integrated third-party payment gateways&#10;Optimized database queries">{{ old('responsibilities') }}</textarea>
            <small class="text-muted">Enter each bullet point on a new line.</small>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-9">
                <label for="tech_stack" class="form-label">Technologies Used (comma separated)</label>
                <input type="text" name="tech_stack" id="tech_stack" class="form-control" value="{{ old('tech_stack') }}" placeholder="Laravel, PHP 8.2, MySQL, REST API, Bootstrap 5">
            </div>
            <div class="col-md-3">
                <label for="sort_order" class="form-label">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn-glass btn-glass-primary px-4 py-2">
                <i class="bi bi-check-lg"></i> Save Experience
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
const isCurrentCheck = document.getElementById('is_current');
const endDateCol = document.getElementById('endDateCol');
if (isCurrentCheck && endDateCol) {
    const toggleEndDate = () => {
        endDateCol.style.opacity = isCurrentCheck.checked ? '0.4' : '1';
        endDateCol.querySelector('input').disabled = isCurrentCheck.checked;
    };
    isCurrentCheck.addEventListener('change', toggleEndDate);
    toggleEndDate();
}
</script>
@endpush
