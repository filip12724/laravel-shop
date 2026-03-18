@extends('layouts.admin')
@section('title', 'Products')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Products</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus mr-1"></i> Add Product
        </a>
    </div>
    <div class="card-body">
        <form class="mb-3 d-flex gap-2" method="GET">
            <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search products..." value="{{ request('search') }}">
            <button class="btn btn-sm btn-secondary" type="submit">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            @endif
        </form>

        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th width="60">Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" width="50" height="50" style="object-fit:cover;" class="rounded">
                        @else
                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                <i class="fas fa-image text-white"></i>
                            </div>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <span class="badge badge-{{ $product->active ? 'success' : 'secondary' }}">
                            {{ $product->active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-xs btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-xs btn-danger btn-delete" data-url="{{ route('admin.products.destroy', $product) }}" data-name="{{ $product->name }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $products->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).on('click', '.btn-delete', function () {
    const url  = $(this).data('url');
    const name = $(this).data('name');
    const row  = $(this).closest('tr');

    if (!confirm(`Delete product "${name}"?`)) return;

    $.ajax({
        url,
        type: 'DELETE',
        data: { _token: '{{ csrf_token() }}' },
        success: function (res) {
            if (res.success) {
                row.fadeOut(300, () => row.remove());
            }
        }
    });
});
</script>
@endpush
