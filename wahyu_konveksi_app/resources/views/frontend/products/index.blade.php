@extends('frontend.layouts.app')

@section('title', 'Produk Kami')

@section('content')

@include('frontend.auth.components.header-spacer')

<section class="container py-5">

    {{-- Judul --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold display-6">
            Produk <span class="text-primary">WHS Konveksindo</span>
        </h2>
        <p class="text-muted fs-5">
            Pilihan produk konveksi terbaik untuk kebutuhan Anda
        </p>
    </div>

    {{-- GRID + SIDEBAR --}}
    <div class="row g-4">

        {{-- Sidebar filter kanan --}}
        <div class="col-lg-3 order-lg-2 col-12">
            @include('frontend.products.components.filter', compact('categories'))
        </div>

        {{-- Produk --}}
        <div class="col-lg-9 order-lg-1 col-12">
            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                        @include('frontend.products.components.product-card', compact('product'))
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        Produk belum tersedia
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
