@extends('layouts.admin')
@section('title', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h3>
    </div>
    <form method="POST"
          action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if(isset($product)) @method('PUT') @endif

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Price ($) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" step="0.01" min="0" value="{{ old('price', $product->price ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Stock <span class="text-danger">*</span></label>
                        <input type="number" name="stock" class="form-control" min="0" value="{{ old('stock', $product->stock ?? 0) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control-file" accept="image/*">
                        @if(isset($product) && $product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="mt-2 rounded" style="max-height:100px;">
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1"
                                {{ old('active', $product->active ?? true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="active">Active</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> {{ isset($product) ? 'Update' : 'Create' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
