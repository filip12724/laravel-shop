@extends('layouts.admin')
@section('title', 'Categories')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Categories</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus mr-1"></i> Add Category
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-sm">
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
                    <td>{{ $category->name }}</td>
                    <td><code>{{ $category->slug }}</code></td>
                    <td>{{ Str::limit($category->description, 60) }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-xs btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-xs btn-danger btn-delete"
                                data-url="{{ route('admin.categories.destroy', $category) }}"
                                data-name="{{ $category->name }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $categories->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).on('click', '.btn-delete', function () {
    const url  = $(this).data('url');
    const name = $(this).data('name');
    const row  = $(this).closest('tr');

    if (!confirm(`Delete category "${name}"? All products in this category will also be deleted.`)) return;

    $.ajax({
        url,
        type: 'DELETE',
        data: { _token: '{{ csrf_token() }}' },
        success: function (res) {
            if (res.success) row.fadeOut(300, () => row.remove());
        }
    });
});
</script>
@endpush
