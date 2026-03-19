@extends('layouts.admin')
@section('title', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title">
                    <i class="fas fa-{{ isset($product) ? 'edit' : 'plus-circle' }} mr-2" style="color:#4f46e5;"></i>
                    {{ isset($product) ? 'Edit Product' : 'Add Product' }}
                </h3>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>

            <form method="POST"
                  action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @if(isset($product)) @method('PUT') @endif

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <ul class="mb-0 pl-3 mt-1">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        {{-- Left column --}}
                        <div class="col-md-8">

                            <div class="form-group mb-4">
                                <label style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;">
                                    <i class="fas fa-box mr-1" style="color:#4f46e5;"></i>Name <span style="color:#ef4444;">*</span>
                                </label>
                                <input type="text" name="name"
                                       value="{{ old('name', $product->name ?? '') }}"
                                       placeholder="e.g. Wireless Headphones"
                                       class="form-control @error('name') is-invalid @enderror"
                                       required>
                                @error('name')
                                    <div style="font-size:.78rem;color:#ef4444;margin-top:4px;"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;">
                                    <i class="fas fa-tag mr-1" style="color:#4f46e5;"></i>Category <span style="color:#ef4444;">*</span>
                                </label>
                                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">— Select a category —</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div style="font-size:.78rem;color:#ef4444;margin-top:4px;"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;">
                                    <i class="fas fa-align-left mr-1" style="color:#4f46e5;"></i>Description
                                    <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#94a3b8;font-size:.75rem;margin-left:4px;">optional</span>
                                </label>
                                <textarea name="description"
                                          rows="6"
                                          placeholder="Describe the product…"
                                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description ?? '') }}</textarea>
                                @error('description')
                                    <div style="font-size:.78rem;color:#ef4444;margin-top:4px;"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Right column --}}
                        <div class="col-md-4">

                            <div class="form-group mb-4">
                                <label style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;">
                                    <i class="fas fa-dollar-sign mr-1" style="color:#4f46e5;"></i>Price <span style="color:#ef4444;">*</span>
                                </label>
                                <input type="number" name="price"
                                       class="form-control @error('price') is-invalid @enderror"
                                       step="0.01" min="0"
                                       placeholder="0.00"
                                       value="{{ old('price', $product->price ?? '') }}" required>
                                @error('price')
                                    <div style="font-size:.78rem;color:#ef4444;margin-top:4px;"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;">
                                    <i class="fas fa-cubes mr-1" style="color:#4f46e5;"></i>Stock <span style="color:#ef4444;">*</span>
                                </label>
                                <input type="number" name="stock"
                                       class="form-control @error('stock') is-invalid @enderror"
                                       min="0"
                                       placeholder="0"
                                       value="{{ old('stock', $product->stock ?? 0) }}" required>
                                @error('stock')
                                    <div style="font-size:.78rem;color:#ef4444;margin-top:4px;"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;">
                                    <i class="fas fa-image mr-1" style="color:#4f46e5;"></i>Image
                                    <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#94a3b8;font-size:.75rem;margin-left:4px;">optional</span>
                                </label>
                                @if(isset($product) && $product->image)
                                    <div class="mb-2">
                                        <img id="imagePreview" src="{{ asset('storage/'.$product->image) }}"
                                             style="height:90px;border-radius:8px;object-fit:cover;border:2px solid #edf0f7;">
                                    </div>
                                @else
                                    <img id="imagePreview" src="" style="display:none;height:90px;border-radius:8px;object-fit:cover;border:2px solid #edf0f7;margin-bottom:8px;">
                                @endif
                                <input type="file" name="image" id="imageInput"
                                       accept="image/*"
                                       class="@error('image') is-invalid @enderror"
                                       style="display:none;">
                                <label for="imageInput" id="imageLabel" style="
                                    display:inline-flex;align-items:center;gap:8px;
                                    padding:8px 16px;border:1.5px dashed #c7d2fe;border-radius:8px;
                                    background:#f8f9ff;color:#4f46e5;font-size:.85rem;font-weight:600;
                                    cursor:pointer;transition:all .18s;width:100%;justify-content:center;
                                    text-transform:none;letter-spacing:0;">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span id="imageLabelText">Choose image…</span>
                                </label>
                                @error('image')
                                    <div style="font-size:.78rem;color:#ef4444;margin-top:4px;"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;display:block;margin-bottom:8px;">
                                    <i class="fas fa-toggle-on mr-1" style="color:#4f46e5;"></i>Visibility
                                </label>
                                <label style="cursor:pointer;margin:0;display:inline-flex;align-items:center;gap:10px;
                                              background:#fff;border:1px solid #e2e8f0;border-radius:8px;
                                              padding:8px 14px;text-transform:none;letter-spacing:0;color:#2d3748;font-size:.875rem;font-weight:500;">
                                    <input type="checkbox" name="active" value="1"
                                           {{ old('active', $product->active ?? true) ? 'checked' : '' }}
                                           style="width:16px;height:16px;accent-color:#4f46e5;flex-shrink:0;cursor:pointer;">
                                    Active (visible in shop)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer" style="display:flex;gap:10px;align-items:center;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-{{ isset($product) ? 'save' : 'plus' }} mr-1"></i>
                        {{ isset($product) ? 'Save Changes' : 'Create Product' }}
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('imageInput').addEventListener('change', function () {
    const file = this.files[0];
    const label = document.getElementById('imageLabelText');
    const preview = document.getElementById('imagePreview');

    if (file) {
        label.textContent = file.name;
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            preview.style.marginBottom = '8px';
        };
        reader.readAsDataURL(file);
    } else {
        label.textContent = 'Choose image…';
    }
});

document.getElementById('imageLabel').addEventListener('mouseover', function () {
    this.style.borderColor = '#4f46e5';
    this.style.background = '#eef2ff';
});
document.getElementById('imageLabel').addEventListener('mouseout', function () {
    this.style.borderColor = '#c7d2fe';
    this.style.background = '#f8f9ff';
});
</script>
@endpush
