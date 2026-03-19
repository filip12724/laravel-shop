@extends('layouts.admin')
@section('title', isset($category) ? 'Edit Category' : 'Add Category')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title">
                    <i class="fas fa-{{ isset($category) ? 'edit' : 'plus-circle' }} mr-2" style="color:#4f46e5;"></i>
                    {{ isset($category) ? 'Edit Category' : 'Add Category' }}
                </h3>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>

            <form method="POST"
                  action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
                @csrf
                @if(isset($category)) @method('PUT') @endif

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <ul class="mb-0 pl-3 mt-1">
                                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Name --}}
                    <div class="form-group mb-4">
                        <label style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;">
                            <i class="fas fa-tag mr-1" style="color:#4f46e5;"></i>Name <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" name="name"
                               value="{{ old('name', $category->name ?? '') }}"
                               placeholder="e.g. Electronics"
                               class="form-control @error('name') is-invalid @enderror"
                               required>
                        @error('name')
                            <div style="font-size:.78rem;color:#ef4444;margin-top:4px;"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group mb-0">
                        <label style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;">
                            <i class="fas fa-align-left mr-1" style="color:#4f46e5;"></i>Description
                            <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#94a3b8;font-size:.75rem;margin-left:4px;">optional</span>
                        </label>
                        <textarea name="description"
                                  rows="4"
                                  placeholder="Brief description of this category…"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description ?? '') }}</textarea>
                        @error('description')
                            <div style="font-size:.78rem;color:#ef4444;margin-top:4px;"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer" style="display:flex;gap:10px;align-items:center;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-{{ isset($category) ? 'save' : 'plus' }} mr-1"></i>
                        {{ isset($category) ? 'Save Changes' : 'Create Category' }}
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
