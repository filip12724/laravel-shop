@extends('layouts.admin')
@section('title', 'Categories')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-tags mr-2" style="color:#4f46e5;"></i>Categories</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus mr-1"></i> Add Category
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Products</th>
                    <th width="100">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:32px;height:32px;background:linear-gradient(135deg,#eef2ff,#e0e7ff);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-tag" style="color:#4f46e5;font-size:.75rem;"></i>
                            </div>
                            <span style="font-weight:600;color:#1a202c;">{{ $category->name }}</span>
                        </div>
                    </td>
                    <td><code>{{ $category->slug }}</code></td>
                    <td style="color:#64748b;font-size:.875rem;">{{ $category->description ? Str::limit($category->description, 60) : '—' }}</td>
                    <td>
                        <span style="background:#eef2ff;color:#4338ca;border-radius:20px;padding:3px 10px;font-size:.78rem;font-weight:600;display:inline-flex;align-items:center;gap:5px;">
                            <i class="fas fa-box" style="font-size:.65rem;"></i>
                            {{ $category->products_count }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-xs btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-xs btn-danger btn-delete"
                                    data-url="{{ route('admin.categories.destroy', $category) }}"
                                    data-name="{{ $category->name }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center" style="padding:32px;color:#94a3b8;">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $categories->links('vendor.pagination.bootstrap-4') }}</div>
</div>

{{-- Delete confirmation modal --}}
<div id="deleteCatModal" style="
    display:none;position:fixed;inset:0;z-index:9999;
    background:rgba(15,23,42,.45);backdrop-filter:blur(3px);
    align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;width:100%;max-width:400px;
                box-shadow:0 24px 60px rgba(0,0,0,.2);overflow:hidden;margin:16px;
                animation:modalIn .2s ease;">
        <div style="padding:24px 24px 0;">
            <div style="width:48px;height:48px;background:#fef2f2;border-radius:12px;
                        display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                <i class="fas fa-trash" style="color:#ef4444;font-size:1.1rem;"></i>
            </div>
            <div style="font-size:1rem;font-weight:700;color:#1a202c;margin-bottom:6px;">Delete category?</div>
            <div id="deleteCatDesc" style="font-size:.875rem;color:#64748b;line-height:1.55;">
                All products in this category will also be deleted. This cannot be undone.
            </div>
        </div>
        <div style="padding:20px 24px 24px;display:flex;gap:10px;justify-content:flex-end;">
            <button id="deleteCatCancel" style="
                padding:8px 18px;border-radius:8px;border:1px solid #e2e8f0;
                background:#fff;color:#475569;font-size:.875rem;font-weight:500;cursor:pointer;">
                Cancel
            </button>
            <button id="deleteCatConfirm" style="
                padding:8px 18px;border-radius:8px;border:none;
                background:#ef4444;color:#fff;font-size:.875rem;font-weight:600;cursor:pointer;
                transition:background .15s;">
                <i class="fas fa-trash mr-1"></i> Delete
            </button>
        </div>
    </div>
</div>

<style>
@keyframes modalIn {
    from { opacity:0; transform:scale(.95) translateY(8px); }
    to   { opacity:1; transform:scale(1)  translateY(0); }
}
#deleteCatConfirm:hover { background:#dc2626 !important; }
</style>
@endsection

@push('scripts')
<script>
let _deleteUrl = null, _deleteRow = null;

$(document).on('click', '.btn-delete', function () {
    _deleteUrl = $(this).data('url');
    _deleteRow = $(this).closest('tr');
    const name = $(this).data('name');
    $('#deleteCatDesc').text(`"${name}" and all its products will be permanently deleted and cannot be recovered.`);
    $('#deleteCatModal').css('display', 'flex');
});

$('#deleteCatCancel').on('click', function () {
    $('#deleteCatModal').hide();
    _deleteUrl = null; _deleteRow = null;
});

$('#deleteCatModal').on('click', function (e) {
    if (e.target === this) { $(this).hide(); _deleteUrl = null; _deleteRow = null; }
});

$('#deleteCatConfirm').on('click', function () {
    if (!_deleteUrl) return;
    const btn = $(this);
    btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Deleting…').prop('disabled', true);
    $.ajax({ url: _deleteUrl, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
        success: res => {
            if (res.success) {
                _deleteRow.fadeOut(300, () => _deleteRow.remove());
                $('#deleteCatModal').hide();
            }
        },
        complete: () => btn.html('<i class="fas fa-trash mr-1"></i> Delete').prop('disabled', false)
    });
});
</script>
@endpush
