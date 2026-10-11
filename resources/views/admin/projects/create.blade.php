@extends('admin.layout')

@section('title', 'Add Project')
@section('page_title', 'Add New Project')
@section('page_subtitle', 'Create a new project showcase entry')

@section('page_actions')
    <a href="{{ route('admin.projects.index') }}" class="btn-glass py-1 px-3" style="font-size: 0.85rem;">
        &larr; Back to List
    </a>
@endsection

@section('content')

<div class="glass p-4" style="max-width: 800px; margin: 0 auto;">
    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3 mb-3">
            <div class="col-md-8">
                <label for="title" class="form-label">Project Title *</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="col-md-4">
                <label for="category" class="form-label">Category *</label>
                <input type="text" name="category" id="category" class="form-control" value="{{ old('category', 'Web Application') }}" required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="slug" class="form-label">URL Slug (leave blank to auto-generate)</label>
                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" placeholder="my-awesome-project">
            </div>
            <div class="col-md-6">
                <label for="image_file" class="form-label">Project Screenshot (Image)</label>
                <input type="file" name="image_file" id="image_file" class="form-control" accept="image/*">
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Short Summary (Card Description) *</label>
            <textarea name="description" id="description" rows="2" class="form-control" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="long_description" class="form-label">Detailed Description / Case Study</label>
            <textarea name="long_description" id="long_description" rows="4" class="form-control">{{ old('long_description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tech_stack" class="form-label">Tech Stack (comma separated) *</label>
            <input type="text" name="tech_stack" id="tech_stack" class="form-control" value="{{ old('tech_stack', 'Laravel, PHP 8.2, MySQL, Bootstrap 5') }}" required>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label for="live_url" class="form-label">Live Demo URL</label>
                <input type="url" name="live_url" id="live_url" class="form-control" value="{{ old('live_url') }}" placeholder="https://example.com">
            </div>
            <div class="col-md-6">
                <label for="github_url" class="form-label">GitHub Repository URL</label>
                <input type="url" name="github_url" id="github_url" class="form-control" value="{{ old('github_url') }}" placeholder="https://github.com/rohitv3319/project">
            </div>
        </div>

        <div class="row g-3 mb-4 align-items-center">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">
                        Featured on Home Page
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <label for="sort_order" class="form-label mb-0 me-2 d-inline">Sort Order:</label>
                <input type="number" name="sort_order" id="sort_order" class="form-control d-inline-block w-auto" value="{{ old('sort_order', 0) }}">
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn-glass btn-glass-primary px-4 py-2">
                <i class="bi bi-check-lg"></i> Create Project
            </button>
        </div>
    </form>
</div>

@endsection
