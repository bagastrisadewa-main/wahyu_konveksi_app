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
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                @include('frontend.products.components.product-card', compact('product'))
            </div>
        @empty
            <div class="col-12 text-center text-muted">
                Produk belum tersedia di kategori ini.
            </div>
        @endforelse
    </div>
</section>

@endsection