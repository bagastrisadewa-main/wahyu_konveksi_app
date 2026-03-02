<section class="container py-5">
    {{-- Judul --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold display-5">Produk <span class="text-primary">Unggulan</span></h2>
        <p class="text-muted fs-4">Pilihan produk terbaik dari kami</p>
    </div>

    {{-- Produk grid --}}
    <div class="row g-4">
        @forelse($products as $product)
            @php
                $images = is_array($product->images) ? $product->images : [];
                $totalPrice = $product->price;
            @endphp

            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                <a href="{{ route('frontend.products.show', $product->slug) }}"  class="text-decoration-none text-dark w-100 h-100 d-block">
                    <div class="card product-card h-100 border-0 shadow-sm overflow-hidden">
                        {{-- IMAGE --}}
                        <div class="product-image-wrapper position-relative" data-images='@json($images)'>
                            <img src="{{ !empty($images) ? asset('storage/'.$images[0]) : asset('assets_frontend/assets/images/no-image.png') }}"
                                 class="product-image"
                                 alt="{{ $product->name }}">
                        </div>

                        {{-- CONTENT --}}
                        <div class="card-body text-center d-flex flex-column px-3 py-4">
                            <span class="badge bg-primary mb-3" style="font-size: 0.95rem;">{{ $product->category?->name }}</span>
                            <h5 class="fw-bold mb-2" style="font-size: 1.1rem;">{{ $product->name }}</h5>
                            <p class="text-muted mb-3 fs-5">Rp {{ number_format($totalPrice,0,',','.') }}</p>
                            <span class="btn btn-sm btn-outline-primary mt-auto py-2 px-4">Detail</span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center text-muted fs-5">
                Produk belum tersedia
            </div>
        @endforelse
    </div>

    {{-- Tombol Lihat Semua Produk --}}
    <div class="text-center mt-5">
        <a href="{{ route('frontend.products.index') }}" class="btn btn-primary btn-lg py-3 px-5">
            Lihat Semua Produk
        </a>
    </div>
</section>

{{-- Script slider gambar produk --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.product-image-wrapper').forEach(wrapper => {
        const images = JSON.parse(wrapper.dataset.images || '[]');
        if(images.length <= 1) return;
        const img = wrapper.querySelector('.product-image');
        let index = 0;
        setInterval(() => {
            index = (index + 1) % images.length;
            img.style.opacity = '0';
            setTimeout(() => {
                img.src = "{{ asset('storage') }}/" + images[index];
                img.style.opacity = '1';
            }, 400);
        }, 5000);
    });
});
</script>

{{-- Tambahkan styling khusus untuk produk unggulan --}}
<style>
.product-card .card-body h5 {
    font-size: 1.15rem; /* lebih besar */
}

.product-card .card-body p {
    font-size: 1.05rem; /* harga lebih jelas */
}

.product-card .card-body .badge {
    font-size: 0.95rem;
    padding: 0.5em 0.7em;
}

.product-card .btn-outline-primary {
    font-size: 0.9rem;
}
</style>
