@forelse($products as $product)
<div class="col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card h-100 shadow-sm product-card">
        <a href="{{ route('shop.show', $product) }}">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     class="card-img-top" style="height:200px;object-fit:cover;"
                     alt="{{ $product->name }}">
            @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                </div>
            @endif
        </a>
        <div class="card-body d-flex flex-column">
            <small class="text-muted">{{ $product->category->name }}</small>
            <h6 class="card-title mt-1">
                <a href="{{ route('shop.show', $product) }}" class="text-decoration-none text-dark">
                    {{ $product->name }}
                </a>
            </h6>
            <p class="text-muted small flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <span class="fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
                <small class="text-muted">Stock: {{ $product->stock }}</small>
            </div>
        </div>
        <div class="card-footer bg-white border-top-0">
            @if($product->stock > 0)
            <button class="btn btn-primary btn-sm w-100 btn-add-cart"
                    data-url="{{ route('cart.add', $product) }}"
                    data-name="{{ $product->name }}">
                <i class="fas fa-cart-plus me-1"></i> Add to Cart
            </button>
            @else
            <button class="btn btn-secondary btn-sm w-100" disabled>Out of Stock</button>
            @endif
        </div>
    </div>
</div>
@empty
<div class="col-12">
    <div class="alert alert-info text-center">
        <i class="fas fa-search me-2"></i>No products found matching your criteria.
    </div>
</div>
@endforelse
