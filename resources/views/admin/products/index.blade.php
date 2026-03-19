@extends('layouts.admin')
@section('title', 'Products')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-box mr-2" style="color:#4f46e5;"></i>Products</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus mr-1"></i> Add Product
        </a>
    </div>
    <div class="card-body">
        <div class="admin-filter-bar" style="padding:16px 18px;">
            <form method="GET" style="display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;width:100%;">
                <div>
                    <label style="display:block;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:5px;">
                        <i class="fas fa-search mr-1" style="color:#4f46e5;"></i>Search
                    </label>
                    <input type="text" name="search"
                           value="{{ request('search') }}"
                           placeholder="Search by name…"
                           style="padding:7px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.85rem;color:#2d3748;background:#fff;outline:none;width:240px;"
                           onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,.12)'"
                           onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                </div>
                <div style="display:flex;gap:8px;align-self:flex-end;">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-search mr-1"></i> Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-times mr-1"></i> Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="60">Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th width="100">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://picsum.photos/seed/'.$product->id.'/50/50' }}"
                             width="44" height="44" style="object-fit:cover;border-radius:8px;border:2px solid #f0f3f9;">
                    </td>
                    <td style="font-weight:600;color:#1a202c;">{{ $product->name }}</td>
                    <td>
                        <span style="background:#eef2ff;color:#4338ca;border-radius:20px;padding:3px 10px;font-size:.75rem;font-weight:600;display:inline-flex;align-items:center;gap:5px;">
                            <i class="fas fa-tag" style="font-size:.6rem;"></i>
                            {{ $product->category->name }}
                        </span>
                    </td>
                    <td style="font-weight:700;color:#4f46e5;">${{ number_format($product->price, 2) }}</td>
                    <td>
                        <span style="font-weight:600;color:{{ $product->stock > 0 ? '#1a202c' : '#ef4444' }};">
                            {{ $product->stock }}
                        </span>
                        @if($product->stock === 0)
                            <span style="font-size:.7rem;color:#ef4444;font-weight:600;margin-left:2px;">out</span>
                        @endif
                    </td>
                    <td>
                        @if($product->active)
                            <span style="background:#f0fdf4;color:#15803d;border-radius:20px;padding:3px 10px;font-size:.75rem;font-weight:600;display:inline-flex;align-items:center;gap:5px;">
                                <span style="width:6px;height:6px;background:#10b981;border-radius:50%;"></span>Active
                            </span>
                        @else
                            <span style="background:#f1f5f9;color:#64748b;border-radius:20px;padding:3px 10px;font-size:.75rem;font-weight:600;display:inline-flex;align-items:center;gap:5px;">
                                <span style="width:6px;height:6px;background:#94a3b8;border-radius:50%;"></span>Inactive
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-xs btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-xs btn-danger btn-delete"
                                    data-url="{{ route('admin.products.destroy', $product) }}"
                                    data-name="{{ $product->name }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center" style="padding:32px;color:#94a3b8;">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $products->links('vendor.pagination.bootstrap-4') }}</div>
</div>

{{-- Delete confirmation modal --}}
<div id="deleteProductModal" style="
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
            <div style="font-size:1rem;font-weight:700;color:#1a202c;margin-bottom:6px;">Delete product?</div>
            <div id="deleteProductDesc" style="font-size:.875rem;color:#64748b;line-height:1.55;">
                This product will be permanently deleted and cannot be recovered.
            </div>
        </div>
        <div style="padding:20px 24px 24px;display:flex;gap:10px;justify-content:flex-end;">
            <button id="deleteProductCancel" style="
                padding:8px 18px;border-radius:8px;border:1px solid #e2e8f0;
                background:#fff;color:#475569;font-size:.875rem;font-weight:500;cursor:pointer;">
                Cancel
            </button>
            <button id="deleteProductConfirm" style="
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
#deleteProductConfirm:hover { background:#dc2626 !important; }
</style>
@endsection

@push('scripts')
<script>
let _deleteUrl = null, _deleteRow = null;

$(document).on('click', '.btn-delete', function () {
    _deleteUrl = $(this).data('url');
    _deleteRow = $(this).closest('tr');
    const name = $(this).data('name');
    $('#deleteProductDesc').text(`"${name}" will be permanently deleted and cannot be recovered.`);
    $('#deleteProductModal').css('display', 'flex');
});

$('#deleteProductCancel').on('click', function () {
    $('#deleteProductModal').hide();
    _deleteUrl = null; _deleteRow = null;
});

$('#deleteProductModal').on('click', function (e) {
    if (e.target === this) { $(this).hide(); _deleteUrl = null; _deleteRow = null; }
});

$('#deleteProductConfirm').on('click', function () {
    if (!_deleteUrl) return;
    const btn = $(this);
    btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Deleting…').prop('disabled', true);
    $.ajax({ url: _deleteUrl, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
        success: res => {
            if (res.success) {
                _deleteRow.fadeOut(300, () => _deleteRow.remove());
                $('#deleteProductModal').hide();
            }
        },
        complete: () => btn.html('<i class="fas fa-trash mr-1"></i> Delete').prop('disabled', false)
    });
});
</script>
@endpush
