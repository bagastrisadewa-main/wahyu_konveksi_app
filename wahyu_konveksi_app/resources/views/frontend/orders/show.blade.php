@extends('frontend.layouts.app')

@section('title', 'Detail Order')

@section('content')
@include('frontend.auth.components.header-spacer')

<div class="container py-5">

    <h3 class="mb-4">Detail Order {{ $order->order_code }}</h3>

    <div class="mb-4">
        <strong>Status:</strong>
        <span class="badge bg-{{ $order->statusData->color ?? 'secondary' }}">
            {{ $order->statusData->name ?? ucfirst($order->status) }}
        </span>
    </div>

    {{-- ORDER ITEMS --}}
    @foreach($order->items as $item)
    @php
        $product = $item->product;
        $images = is_array($product?->images) ? $product->images : [];

        $firstImage = !empty($images)
            ? asset('storage/'.$images[0])
            : asset('assets_frontend/assets/images/no-image.png');

        $secondImage = isset($images[1])
            ? asset('storage/'.$images[1])
            : $firstImage;
    @endphp

    <div class="card mb-3 shadow-sm order-card">
        <div class="row g-0 align-items-center">

            {{-- IMAGE --}}
            <div class="col-md-3">
                <div class="order-img-wrapper">
                    <img src="{{ $firstImage }}" class="order-img" alt="">
                </div>
            </div>

            {{-- DETAIL --}}
            <div class="col-md-9">
                <div class="p-3">

                    <h6 class="fw-bold mb-2">
                        {{ $product->name ?? '-' }}
                    </h6>

                    <div class="small text-muted mb-1">
                        Harga Satuan: Rp {{ number_format($item->price) }}
                    </div>

                    <div class="small mb-1">
                        Qty: <strong>{{ $item->qty }}</strong>
                    </div>

                    @if($item->options->count())
                        <div class="small text-muted mb-1">
                            Options:
                            {{ $item->options->pluck('option_name')->join(', ') }}
                        </div>
                    @endif

                    @if($item->note)
                        <div class="small text-muted mb-1">
                            <strong>Keterangan:</strong> {{ $item->note }}
                        </div>
                    @endif

                    <div class="fw-bold mt-2">
                        Subtotal: Rp {{ number_format($item->subtotal) }}
                    </div>

                </div>
            </div>

        </div>
    </div>
    @endforeach


    {{-- TOTAL SECTION --}}

{{-- TOTAL SECTION --}}
<div class="border-top pt-4 mt-4">

    <div class="text-end mb-4">
        <div class="fw-bold total-text">
            Total: Rp {{ number_format($order->total_price) }}
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center">

        {{-- LEFT : KEMBALI --}}
        <a href="{{ route('frontend.orders.history') }}"
           class="btn btn-dark px-4">
            ← Kembali
        </a>

        {{-- RIGHT : PESAN LAGI --}}
        <form method="POST"
              action="{{ route('frontend.orders.reorder', $order->id) }}">
            @csrf
            <button class="btn btn-dark px-4">
                🔄 Pesan Produk Lagi
            </button>
        </form>

    </div>

</div>

<style>

.order-card {
    border-radius: 24px;
    border: none;
    overflow: hidden;
}

.order-img-wrapper {
    height: 150px;
    background: #f8f9fa; /* biar kalau ada ruang kosong tetap rapi */
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
}

.order-img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain; /* 🔥 ini bikin tidak kepotong */
}

.total-text {
    font-size: 22px;
}

.total-text {
    font-size: 22px;
}

</style>

@endsection