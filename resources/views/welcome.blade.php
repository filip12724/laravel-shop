@extends('layouts.app')
@section('title', 'Welcome to Laravel Shop')

@section('content')
<div class="text-center py-5">
    <h1 class="display-4 fw-bold mb-3">Welcome to <span class="text-primary">Laravel Shop</span></h1>
    <p class="lead text-muted mb-4">Discover our wide selection of quality products at great prices.</p>
    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg px-5">
        <i class="fas fa-store me-2"></i>Browse Products
    </a>
</div>
@endsection
