@extends('layouts.admin')
@section('title', isset($category) ? 'Edit Category' : 'Add Category')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header">
        <h3 class="card-title">{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h3>
    </div>
    <form method="POST"
          action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
        @csrf
        @if(isset($category)) @method('PUT') @endif

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label>Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
            </div>
        </div>

        <div class="card-footer d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> {{ isset($category) ? 'Update' : 'Create' }}
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
