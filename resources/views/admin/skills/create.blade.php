@extends('admin.layout')

@section('title', 'Add Skill')
@section('page_title', 'Add New Skill')
@section('page_subtitle', 'Add a new technology, framework, database, or tool')

@section('page_actions')
    <a href="{{ route('admin.skills.index') }}" class="btn-glass py-1 px-3" style="font-size: 0.85rem;">
        &larr; Back to Skills
    </a>
@endsection

@section('content')

<div class="glass p-4" style="max-width: 820px; margin: 0 auto;">
    <form action="{{ route('admin.skills.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3 mb-3">
            <div class="col-md-7">
                <label for="name" class="form-label">Skill Name *</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       class="form-control" 
                       placeholder="e.g. Laravel, PHP, Filament, Docker" 
                       value="{{ old('name') }}" 
                       required>
            </div>
            <div class="col-md-5">
                <label for="category" class="form-label">Category</label>
                <input type="text" 
                       name="category" 
                       id="category" 
                       list="categoryList" 
                       class="form-control" 
                       placeholder="e.g. Backend, Frontend, Database, Tools" 
                       value="{{ old('category') }}">
                <datalist id="categoryList">
                    @foreach($existingCategories as $cat)
                        <option value="{{ $cat }}"></option>
                    @endforeach
                    <option value="Backend"></option>
                    <option value="Frontend"></option>
                    <option value="Database"></option>
                    <option value="Tools"></option>
                </datalist>
            </div>
        </div>

        <!-- Icon Type Selector -->
        <div class="mb-3">
            <label class="form-label d-block">Icon Representation *</label>
            <div class="d-flex gap-4">
                <div class="form-check">
                    <input class="form-check-input" 
                           type="radio" 
                           name="icon_type" 
                           id="icon_type_class" 
                           value="class" 
                           {{ old('icon_type', 'class') === 'class' ? 'checked' : '' }}>
                    <label class="form-check-label" for="icon_type_class">
                        <i class="bi bi-fonts me-1"></i> Icon Class (Bootstrap Icons / Devicon)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" 
                           type="radio" 
                           name="icon_type" 
                           id="icon_type_image" 
                           value="image" 
                           {{ old('icon_type') === 'image' ? 'checked' : '' }}>
                    <label class="form-check-label" for="icon_type_image">
                        <i class="bi bi-image me-1"></i> Custom Image Upload (PNG, SVG, WEBP)
                    </label>
                </div>
            </div>
        </div>

        <!-- Class Icon Input (Visible when class chosen) -->
        <div class="mb-3" id="classIconSection">
            <label for="icon_class" class="form-label">Icon CSS Class</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0" id="liveIconPreviewWrap" style="border-color: var(--input-border); min-width: 46px; text-align: center;">
                    <i id="liveIconPreview" class="bi bi-code-slash fs-5" style="color: var(--accent);"></i>
                </span>
                <input type="text" 
                       name="icon_class" 
                       id="icon_class" 
                       class="form-control border-start-0" 
                       placeholder="e.g. bi bi-fire, bi bi-filetype-php, bi bi-database" 
                       value="{{ old('icon_class', 'bi bi-code-slash') }}">
            </div>
            <small class="text-muted">
                Supports any Bootstrap Icons class (<a href="https://icons.getbootstrap.com/" target="_blank" class="text-accent text-decoration-none">browse icons &rarr;</a>) or custom CSS icon classes.
            </small>
        </div>

        <!-- Image Upload Input (Visible when image chosen) -->
        <div class="mb-3 d-none" id="imageIconSection">
            <label for="icon_image_file" class="form-label">Upload Skill Icon Image (Max: 1 MB)</label>
            <div class="d-flex align-items-center gap-3">
                <div id="imagePreviewContainer" 
                     class="d-flex align-items-center justify-content-center rounded" 
                     style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <img id="imagePreview" src="" alt="Preview" class="d-none" style="width: 32px; height: 32px; object-fit: contain;">
                    <i id="imagePlaceholder" class="bi bi-image text-muted fs-4"></i>
                </div>
                <div class="flex-grow-1">
                    <input type="file" 
                           name="icon_image_file" 
                           id="icon_image_file" 
                           class="form-control" 
                           accept="image/jpeg,image/png,image/webp,image/svg+xml">
                    <small class="text-muted">Saved safely to <code>public/uploads/skills</code>.</small>
                </div>
            </div>
        </div>

        <!-- Proficiency Range Slider -->
        <div class="p-3 rounded mb-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label for="proficiency" class="form-label mb-0">Proficiency Level</label>
                <span id="proficiencyValueBadge" class="badge bg-primary">Not Specified</span>
            </div>

            <input type="range" 
                   class="form-range" 
                   min="0" 
                   max="100" 
                   step="5" 
                   id="proficiency" 
                   name="proficiency" 
                   value="{{ old('proficiency', 0) }}" 
                   {{ old('no_proficiency', true) ? 'disabled' : '' }}>

            <div class="form-check mt-2">
                <input class="form-check-input" 
                       type="checkbox" 
                       id="no_proficiency" 
                       name="no_proficiency" 
                       value="1" 
                       {{ old('no_proficiency', true) ? 'checked' : '' }}>
                <label class="form-check-label text-muted" for="no_proficiency" style="font-size: 0.85rem;">
                    Don't show percentage bar (leave proficiency blank)
                </label>
            </div>
        </div>

        <div class="row g-3 mb-4 align-items-center">
            <div class="col-md-6">
                <label for="sort_order" class="form-label">Sort Order</label>
                <input type="number" 
                       name="sort_order" 
                       id="sort_order" 
                       class="form-control" 
                       value="{{ old('sort_order', 0) }}">
                <small class="text-muted">Lowest number displays first.</small>
            </div>
            <div class="col-md-6 pt-3">
                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1" 
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Active (Visible on public portfolio)
                    </label>
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn-glass btn-glass-primary px-4 py-2">
                <i class="bi bi-check-lg"></i> Save Skill
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Icon Type Toggle
    const typeClassRadio = document.getElementById('icon_type_class');
    const typeImageRadio = document.getElementById('icon_type_image');
    const classSection = document.getElementById('classIconSection');
    const imageSection = document.getElementById('imageIconSection');

    function toggleIconType() {
        if (typeImageRadio.checked) {
            classSection.classList.add('d-none');
            imageSection.classList.remove('d-none');
        } else {
            classSection.classList.remove('d-none');
            imageSection.classList.add('d-none');
        }
    }
    typeClassRadio.addEventListener('change', toggleIconType);
    typeImageRadio.addEventListener('change', toggleIconType);
    toggleIconType();

    // 2. Icon Class Live Preview
    const iconClassInput = document.getElementById('icon_class');
    const liveIconPreview = document.getElementById('liveIconPreview');
    iconClassInput.addEventListener('input', function () {
        const val = this.value.trim();
        liveIconPreview.className = val || 'bi bi-code-slash';
    });

    // 3. Image File Live Preview
    const imageInput = document.getElementById('icon_image_file');
    const imagePreview = document.getElementById('imagePreview');
    const imagePlaceholder = document.getElementById('imagePlaceholder');

    imageInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (evt) {
                imagePreview.src = evt.target.result;
                imagePreview.classList.remove('d-none');
                imagePlaceholder.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    // 4. Proficiency Slider and Checkbox Sync
    const slider = document.getElementById('proficiency');
    const noProfCheck = document.getElementById('no_proficiency');
    const badge = document.getElementById('proficiencyValueBadge');

    function updateProficiency() {
        if (noProfCheck.checked) {
            slider.disabled = true;
            badge.textContent = 'Not Specified';
            badge.className = 'badge bg-secondary';
        } else {
            slider.disabled = false;
            badge.textContent = slider.value + '%';
            badge.className = 'badge bg-primary';
        }
    }

    slider.addEventListener('input', updateProficiency);
    noProfCheck.addEventListener('change', updateProficiency);
    updateProficiency();
});
</script>
@endpush
