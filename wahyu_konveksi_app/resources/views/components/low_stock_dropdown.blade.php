@if($products->count())
    <div class="dropdown-title">Stok Menipis (≤ 5)</div>
    @foreach ($products as $product)
        <a href="{{ route('product.edit', $product->id) }}" class="dropdown-item">
            <div class="dropdown-item-desc">
                <strong>{{ $product->name }}</strong><br>
                <small class="text-danger">Sisa stok: {{ $product->stock }}</small>
            </div>
        </a>
    @endforeach
@else
    <div class="dropdown-title text-success">Semua stok aman 🎉</div>
@endif

