@extends('frontend.layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
@include('frontend.auth.components.header-spacer')

<section class="cart-section my-5">
<div class="container">
<div class="row">

{{-- ================= LEFT : ITEM CART ================= --}}
<div class="col-lg-8">
<h3>Keranjang Belanja</h3>

<ul class="list-group mb-4" id="cart-items">
@forelse($cartItems as $item)
@php
    $images = is_array($item->product->images) ? $item->product->images : [];
    $imageSrc = !empty($images)
        ? asset('storage/'.$images[0])
        : asset('assets_frontend/assets/images/no-image.png');
    $extra = $item->options->sum('extra_price');
@endphp

<li class="list-group-item d-flex justify-content-between align-items-center"
    data-id="{{ $item->id }}"
    data-price="{{ $item->price }}"
    data-extra="{{ $extra }}">
    
{{-- tombol hapus item di cart --}}
        <button class="btn-remove-item"
            data-id="{{ $item->id }}">
        &times;
    </button>

    <div class="d-flex align-items-center">
        <img src="{{ $imageSrc }}" width="70" class="me-3">
        <div>
            <h5 class="mb-1">{{ $item->product->name }}</h5>
            <small class="text-muted">Harga Satuan: Rp {{ number_format($item->price) }}</small>
            @if($item->options->count())
                <br>
                <small class="text-muted">
                    Options: {{ $item->options->pluck('option_name')->join(', ') }}
                </small>
            @endif
                @if($item->note)
                   <small class="text-muted d-block mt-1">
                        <strong>Keterangan Customer:</strong> {{ $item->note }}
                    </small>
                @endif
        </div>
    </div>

    <div class="text-end">
        <input type="number"
            min="0"
            class="form-control text-center item-qty mb-1"
            value="{{ $item->qty }}"
            style="width:70px">

        <small class="item-subtotal">
            Subtotal: Rp <span>{{ number_format($item->subtotal) }}</span>
        </small>
    </div>
</li>

@empty
<li class="list-group-item text-center">
    Keranjang belanja kosong <br>
    <a href="{{ route('frontend.products.index') }}"
       class="btn btn-primary mt-2">
        Silakan pilih produk
    </a>
</li>
@endforelse
</ul>

{{-- Tombol Pilih Produk Lagi: hanya muncul jika ada item --}}
@if($cartItems->isNotEmpty())
    <a href="{{ route('frontend.products.index') }}" 
       class="btn btn-outline-primary w-100 mb-3">
        Pilih Produk Lagi
    </a>
@endif

</div>

{{-- ================= RIGHT : RINGKASAN ================= --}}
<div class="col-lg-4">
<div class="card p-3">
<h5>Ringkasan Pesanan</h5>
<hr>

<p>Total Item:
    <strong id="total-items">{{ $cartItems->sum('qty') }}</strong>
</p>

<p>Total Harga:
    <strong id="total-price">
        Rp {{ number_format($total) }}
    </strong>
</p>

<hr>

@auth('customer')
    <p class="mb-1"><strong>Nama:</strong> {{ $customer->name }}</p>
    <p class="mb-1"><strong>No. WA:</strong> {{ $customer->phone }}</p>
    <p class="mb-3"><strong>Alamat:</strong> {{ $customer->address }}</p>

    @php
        $waUrl = session('wa_url') ?? '';
    @endphp

<button
    class="btn btn-success w-100"
    id="checkout-wa-btn"
    data-action="checkout"
    {{ $cartItems->sum('qty') == 0 ? 'disabled' : '' }}>
    Checkout Pesanan
</button>
@if($cartItems->sum('qty') == 0)
    <small class="text-muted d-block text-center mt-2">
        Silakan pilih produk terlebih dahulu
    </small>
@endif

{{-- 
    <a href="{{ route('frontend.products.index') }}" class="btn btn-outline-primary w-100 mt-2">
        Pilih Produk Lagi
    </a> --}}
@else
    <a href="{{ route('frontend.login') }}"
       class="btn btn-primary w-100">
        Login untuk Checkout
    </a>
@endauth

</div>
</div>

</div>
</div>
</section>

<style>
.btn-remove-item{
    position:absolute;
    top:10px;
    right:10px;
    width:28px;
    height:28px;
    border-radius:50%;
    border:none;
    background:#dc3545;
    color:#fff;
    font-size:18px;
    line-height:28px;
    padding:0;
    cursor:pointer;
}

.btn-remove-item:hover{
    background:#b02a37;
}
</style>

{{-- ================= JAVASCRIPT REALTIME ================= --}}
<script>
console.log('🔥 Cart JS Loaded');

const cart = document.getElementById('cart-items');
const checkoutBtn = document.getElementById('checkout-wa-btn');

function recalcCart(){
    let totalQty = 0;
    let totalPrice = 0;

    cart.querySelectorAll('li[data-id]').forEach(li => {
        const price = Number(li.dataset.price);
        const extra = Number(li.dataset.extra);
        const qtyEl = li.querySelector('.item-qty');
        const qty = Number(qtyEl.value) || 0;

        const subtotal = (price + extra) * qty;

        li.querySelector('.item-subtotal span')
          .innerText = subtotal.toLocaleString('id-ID');

        totalQty += qty;
        totalPrice += subtotal;
    });

    document.getElementById('total-items').innerText = totalQty;
    document.getElementById('total-price').innerText =
        'Rp ' + totalPrice.toLocaleString('id-ID');

            // 🔥 Update badge header (desktop & mobile)
    updateCartBadge(totalQty);
}

// REaltime qty update + sync ke backend
cart.addEventListener('input', e => {
    if (!e.target.classList.contains('item-qty')) return;

    const li = e.target.closest('li');
    const id = li.dataset.id;
    const qty = Number(e.target.value) || 0;

    // 🔁 Sync ke backend tetap jalan
    fetch(`/cart/ajax/update/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ qty })
    })

    //tambahan kode

    .then(res => res.json())
    .then(data => {
        recalcCart(); // pakai hitungan realtime frontend
    });

    // 🗑️ JIKA QTY = 0 → HAPUS CARD REALTIME
    if (qty === 0) {
        li.remove();
    }

    recalcCart();

   
    // 🔒 Disable hanya jika MODE CHECKOUT & cart kosong
    const remainingItems = cart.querySelectorAll('li[data-id]').length;

    if (checkoutBtn) {
        const action = checkoutBtn.dataset.action;

        if (remainingItems === 0 && action === 'checkout') {
            checkoutBtn.disabled = true;
        }
    }

});


// ================= BUTTON CHECKOUT / WA =================

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function(e){

            // 🔒 HARD STOP jika tombol disabled (anti inspect / force click)
            if (this.disabled) {
                e.preventDefault();
                return;
            }

            e.preventDefault();
            const btn = e.currentTarget;
            const action = btn.dataset.action;

            if(action === 'checkout'){
                window.location.href = "{{ route('frontend.cart.checkout-wa') }}";
            }
            else if(action === 'wa'){
                const waUrl = btn.dataset.waUrl;
                if(waUrl){
                    window.open(waUrl, '_blank');

                    btn.innerText = 'Order Lagi';
                    btn.classList.remove('btn-warning');
                    btn.classList.add('btn-primary');
                    btn.dataset.action = 'order-again';
                }
            }
            else if(action === 'order-again'){
                window.location.href = "{{ route('frontend.products.index') }}";
            }
        });
    }


    // ================= REMOVE ITEM =================
cart.addEventListener('click', function(e){
    if(!e.target.classList.contains('btn-remove-item')) return;

    const btn = e.target;
    const id = btn.dataset.id;
    const li = btn.closest('li');

    fetch(`/cart/ajax/update/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ qty: 0 })
    })
    .then(res => res.json())
    .then(data => {
        li.remove();
        recalcCart();

        const remainingItems = cart.querySelectorAll('li[data-id]').length;
        if(checkoutBtn && remainingItems === 0){
            checkoutBtn.disabled = true;
        }
    });
});

</script>

{{-- ================= TOAST SUCCESS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success') && session('wa_url'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('checkout-wa-btn');
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        html: @json(session('success')),
        showConfirmButton: false,
        timer: 2000,
        willClose: () => {
            // ubah tombol jadi Kirim WA
            btn.innerText = 'Kirim ke WhatsApp';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-warning');
            btn.dataset.action = 'wa';
            btn.dataset.waUrl = @json(session('wa_url'));

            // 🔓 ENABLE tombol
            btn.disabled = false;
                }
    });
});
</script>
@endif







@endsection
