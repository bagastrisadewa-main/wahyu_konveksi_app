@extends('frontend.layouts.app')

@section('title', $category->name)

@section('content')

{{-- Slider (pakai yang sama dengan beranda) --}}
@include('frontend.pages.beranda.components.slider', ['sliders' => $sliders])

{{-- Judul Kategori --}}
<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold display-6">{{ $category->name }}</h2>
        @if($category->description)
            <p class="text-muted fs-5">{{ $category->description }}</p>
        @endif
    </div>

    {{-- Produk --}}
    <div class="row g-4">
        @forelse($products as $product)
            @php
                $images = is_array($product->images) ? $product->images : [];
                $totalPrice = $product->price;
            @endphp

            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                <a href="{{ route('frontend.products.show', $product) }}" class="text-decoration-none text-dark w-100 h-100 d-block">
                    <div class="card product-card h-100 border-0 shadow-sm overflow-hidden">
                        {{-- IMAGE --}}
                        <div class="product-image-wrapper position-relative" data-images='@json($images)'>
                            <img src="{{ !empty($images) ? asset('storage/'.$images[0]) : asset('assets_frontend/assets/images/no-image.png') }}"
                                 class="product-image"
                                 alt="{{ $product->name }}">
                        </div>

                        {{-- CONTENT --}}
                        <div class="card-body text-center d-flex flex-column px-3">
                            <span class="badge bg-primary mb-2">{{ $product->category?->name }}</span>
                            <h5 class="fw-bold mb-1 mt-1">{{ $product->name }}</h5>
                            <p class="text-muted mb-3">Rp {{ number_format($totalPrice,0,',','.') }}</p>
                            <span class="btn btn-sm btn-outline-primary mt-auto">Detail</span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center text-muted">
                Produk belum tersedia di kategori ini.
            </div>
        @endforelse
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

@endsection
