@extends('admin.layout')

@section('title', 'Skills Manager')
@section('page_title', 'Skills Manager')
@section('page_subtitle', 'Manage tech stack skills, icons, proficiencies, and display order')

@section('page_actions')
    <a href="{{ route('admin.skills.create') }}" class="btn-glass btn-glass-primary py-1 px-3" style="font-size: 0.85rem;">
        <i class="bi bi-plus-lg"></i> Add Skill
    </a>
@endsection

@section('content')

<!-- Search & Category Filters -->
<div class="glass p-3 mb-4">
    <form action="{{ route('admin.skills.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--input-border); color: var(--accent);">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" 
                       name="search" 
                       class="form-control border-start-0 ps-0" 
                       placeholder="Search skills by name or category..." 
                       value="{{ request('search') }}">
            </div>
        </div>

        <div class="col-md-4">
            <select name="category" class="form-select" onchange="this.form.submit()">
                <option value="all">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn-glass py-1 px-3 flex-grow-1" style="font-size: 0.85rem;">
                <i class="bi bi-funnel"></i> Filter
            </button>
            @if(request()->hasAny(['search', 'category']))
                <a href="{{ route('admin.skills.index') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center" title="Reset Filters">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Skills List Table -->
<div class="glass p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <small class="text-muted">
            <i class="bi bi-grip-vertical me-1"></i> Drag rows using the grip handle to reorder live
        </small>
        <span id="reorderNotice" class="badge bg-success d-none">
            <i class="bi bi-check2 me-1"></i> Order Saved
        </span>
    </div>

    @if($skills->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-tools text-muted fs-1 mb-3 d-block"></i>
            <h5>No Skills Found</h5>
            <p class="text-muted">Click "Add Skill" to create a new technology or tool entry.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="skillsTable">
                <thead>
                    <tr class="text-muted" style="font-size: 0.85rem;">
                        <th style="width: 40px;"></th>
                        <th style="width: 70px;">Icon</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Proficiency</th>
                        <th>Active</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortableSkillsBody">
                    @foreach($skills as $skill)
                        <tr data-id="{{ $skill->id }}" class="skill-row">
                            <td class="text-muted drag-handle" style="cursor: grab; width: 40px;" title="Drag to reorder">
                                <i class="bi bi-grip-vertical fs-5"></i>
                            </td>
                            <td>
                                <div class="skill-icon-preview d-flex align-items-center justify-content-center rounded" 
                                     style="width: 44px; height: 44px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                                    @if($skill->icon_type === 'image' && $skill->icon_image)
                                        <img src="{{ asset($skill->icon_image) }}" 
                                             alt="{{ $skill->name }}" 
                                             style="width: 28px; height: 28px; object-fit: contain;">
                                    @elseif($skill->icon_class)
                                        <i class="{{ $skill->icon_class }} fs-4" style="color: var(--accent);"></i>
                                    @else
                                        <i class="bi bi-code-slash text-muted fs-4"></i>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <strong style="color: var(--text-main); font-size: 0.95rem;">{{ $skill->name }}</strong>
                            </td>
                            <td>
                                @if($skill->category)
                                    <span class="glass-badge" style="font-size: 0.75rem;">
                                        {{ $skill->category }}
                                    </span>
                                @else
                                    <span class="text-muted" style="font-size: 0.8rem;">Uncategorized</span>
                                @endif
                            </td>
                            <td style="min-width: 150px;">
                                @if(!is_null($skill->proficiency))
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1" style="height: 6px; background: rgba(255, 255, 255, 0.1);">
                                            <div class="progress-bar" 
                                                 role="progressbar" 
                                                 style="width: {{ $skill->proficiency }}%; background: linear-gradient(90deg, var(--primary), var(--accent));"></div>
                                        </div>
                                        <span class="text-muted" style="font-size: 0.78rem;">{{ $skill->proficiency }}%</span>
                                    </div>
                                @else
                                    <span class="text-muted" style="font-size: 0.8rem;">No % set</span>
                                @endif
                            </td>
                            <td>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input skill-status-toggle" 
                                           type="checkbox" 
                                           role="switch" 
                                           data-url="{{ route('admin.skills.toggle', $skill) }}"
                                           {{ $skill->is_active ? 'checked' : '' }}
                                           title="Toggle active status">
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.skills.edit', $skill) }}" 
                                       class="btn btn-sm btn-outline-info" 
                                       title="Edit Skill">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger delete-skill-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteSkillModal"
                                            data-action="{{ route('admin.skills.destroy', $skill) }}"
                                            data-name="{{ $skill->name }}"
                                            title="Delete Skill">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteSkillModal" tabindex="-1" aria-labelledby="deleteSkillModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-heading" id="deleteSkillModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-1" style="color: var(--text-main);">
                    Are you sure you want to permanently delete the skill <strong id="deleteSkillName"></strong>?
                </p>
                <small class="text-muted">If an uploaded icon image is attached, it will also be deleted from the server.</small>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteSkillForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger px-3">
                        <i class="bi bi-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- HTML5 Drag & Drop Reordering and Toggle AJAX -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = '{{ csrf_token() }}';

    // 1. Delete Modal Data Binding
    const deleteButtons = document.querySelectorAll('.delete-skill-btn');
    const deleteForm = document.getElementById('deleteSkillForm');
    const deleteNameSpan = document.getElementById('deleteSkillName');

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const action = this.getAttribute('data-action');
            const name = this.getAttribute('data-name');
            deleteForm.setAttribute('action', action);
            deleteNameSpan.textContent = name;
        });
    });

    // 2. Active Toggle via AJAX
    const toggleInputs = document.querySelectorAll('.skill-status-toggle');
    toggleInputs.forEach(input => {
        input.addEventListener('change', function () {
            const url = this.getAttribute('data-url');
            fetch(url, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    alert('Error updating skill status.');
                    this.checked = !this.checked;
                }
            })
            .catch(() => {
                alert('Server error updating status.');
                this.checked = !this.checked;
            });
        });
    });

    // 3. Native Drag & Drop Reordering
    const sortableBody = document.getElementById('sortableSkillsBody');
    if (sortableBody) {
        let draggedRow = null;

        const rows = sortableBody.querySelectorAll('.skill-row');
        rows.forEach(row => {
            row.setAttribute('draggable', 'true');

            row.addEventListener('dragstart', function (e) {
                draggedRow = this;
                e.dataTransfer.effectAllowed = 'move';
                this.style.opacity = '0.4';
            });

            row.addEventListener('dragend', function () {
                this.style.opacity = '1';
                draggedRow = null;
                saveSkillsOrder();
            });

            row.addEventListener('dragover', function (e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                const bounding = this.getBoundingClientRect();
                const offset = bounding.y + (bounding.height / 2);
                if (e.clientY - offset > 0) {
                    this.after(draggedRow);
                } else {
                    this.before(draggedRow);
                }
            });
        });

        function saveSkillsOrder() {
            const currentRows = sortableBody.querySelectorAll('.skill-row');
            const order = Array.from(currentRows).map(r => r.getAttribute('data-id'));

            fetch('{{ route('admin.skills.reorder') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ order: order })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const notice = document.getElementById('reorderNotice');
                    if (notice) {
                        notice.classList.remove('d-none');
                        setTimeout(() => notice.classList.add('d-none'), 2000);
                    }
                }
            })
            .catch(() => console.error('Error saving reorder'));
        }
    }
});
</script>
@endpush
