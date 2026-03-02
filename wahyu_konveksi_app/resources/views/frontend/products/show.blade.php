@extends('frontend.layouts.app')

@section('title', $product->name)

@section('content')

{{-- ================= NAVBAR / HEADER ================= --}}
 {{-- @include('frontend.layouts.header')  --}}
@include('frontend.auth.components.header-spacer')


@php
  $images = is_array($product->images) ? $product->images : [];
@endphp

<section class="container py-5">

<div class="row g-5">

{{-- ================= LEFT : GALLERY ================= --}}
<div class="col-lg-6 d-flex gap-3">

  {{-- Thumbnails --}}
  <div class="d-flex flex-column gap-2">
    @foreach($images as $i => $img)
      <img src="{{ asset('storage/'.$img) }}"
           class="thumb-img {{ $i===0?'active':'' }}"
           onclick="setImage({{ $i }})">
    @endforeach
  </div>

  {{-- Main --}}
  <div class="position-relative gallery-wrapper">

    {{-- Main image --}}
    <a href="{{ asset('storage/'.$images[0]) }}"
       class="glightbox"
       data-gallery="product-gallery"
       id="mainLink">
      <img id="mainImage"
           src="{{ asset('storage/'.$images[0]) }}"
           class="img-fluid gallery-image">
    </a>

    {{-- Hidden images for swipe --}}
    @foreach($images as $i => $img)
      @if($i>0)
      <a href="{{ asset('storage/'.$img) }}"
         class="glightbox d-none"
         data-gallery="product-gallery"></a>
      @endif
    @endforeach

    {{-- NAV --}}
    <button class="nav-btn left" onclick="prevImage()">‹</button>
    <button class="nav-btn right" onclick="nextImage()">›</button>

  </div>
</div>

{{-- ================= RIGHT : INFO ================= --}}
<div class="col-lg-6">

<h2 class="fw-bold mb-2">{{ $product->name }}</h2>

<h4 class="text-primary mb-3">
    <span id="productPrice">
        Rp {{ number_format($product->price, 0, ',', '.') }}
    </span>
</h4>

{{-- <h4 class="text-primary mb-3">
  <span id="productPrice">Rp {{ number_format($product->price + $product->options->sum(fn($o) => $o->is_required || $product->auto_select_all_custom ? $o->values->sum('extra_price') : 0)) }}</span>
</h4> --}}


<p class="text-muted mb-4">{{ $product->description }}</p>

{{-- ===== OPTIONS ===== --}}
@if($product->options->count())
<div class="border rounded-4 p-3 mb-4">
  <h6 class="fw-bold mb-3">Opsi Tambahan</h6>

  @foreach($product->options as $option)
    <div class="mb-3">
      <div class="fw-semibold">{{ $option->name }}</div>

      @foreach($option->values as $val)
        <div class="form-check">
          <input class="form-check-input option-checkbox"
                 type="checkbox"
                 data-price="{{ $val->extra_price }}"
                 {{ $option->is_required || $product->auto_select_all_custom ? 'checked' : '' }}
                 {{ $option->is_required ? 'disabled' : '' }}>
          <label class="form-check-label">
            {{ $val->label }}
            (+Rp {{ number_format($val->extra_price) }})
          </label>
        </div>
      @endforeach
    </div>
  @endforeach

  {{-- Qty --}}
  <div class="mb-3">
    <label class="fw-semibold">Jumlah</label>
    <input type="number" id="qty"
           class="form-control"
           value="1" min="1">
  </div>

  <div>
    <h4 class="text-primary mb-3">
    <strong>Total Harga :</strong>
    <span id="totalPrice" class="fw-bold text-primary"></span>
    </h4>
  </div>
</div>
@endif

{{-- ===== Tambahan untuk produk tanpa opsi ===== --}}
@if($product->options->count() == 0)
<div class="border rounded-4 p-3 mb-4">
  <div class="mb-3">
    <label class="fw-semibold">Jumlah</label>
    <input type="number" id="qty"
           class="form-control"
           value="1" min="1">
  </div>

  <div>
    <strong>Total:</strong>
    <span id="totalPrice" class="fw-bold text-primary">Rp {{ number_format($product->price) }}</span>
  </div>
</div>
@endif


<textarea class="form-control mb-4"
  placeholder="Catatan tambahan (warna, ukuran, dll)"></textarea>

{{-- Tombol Beli Sekarang --}}
<button id="btnOrder" class="btn btn-primary btn-lg w-100 rounded-3 d-flex align-items-center justify-content-center gap-2">
  <svg width="20" height="20"><use href="#icon_cart"></use></svg>
  Beli Sekarang
</button>

</div>
</div>

{{-- ================= RELATED ================= --}}
<div class="mt-5">
  <h4 class="fw-bold mb-3">Produk Lainnya</h4>

  <div class="row g-4">
    @foreach($relatedProducts as $item)
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
        @include('frontend.products.components.product-card',['product'=>$item])
      </div>
    @endforeach

    @if($relatedProducts->isEmpty())
      <div class="col-12 text-center text-muted">
        Produk lain belum tersedia
      </div>
    @endif
  </div>
</div>


</section>

{{-- ================= CSS ================= --}}
<style>
.gallery-wrapper { position:relative; overflow:hidden; border-radius:18px }
.gallery-image { transition:.4s }
.gallery-wrapper:hover .gallery-image { transform:scale(1.1) }

.thumb-img {
  width:70px;height:70px;object-fit:cover;
  cursor:pointer;border-radius:10px;opacity:.6
}
.thumb-img.active,.thumb-img:hover{
  opacity:1;outline:2px solid #0d6efd
}

.nav-btn{
  position:absolute;top:50%;
  transform:translateY(-50%);
  background:rgba(0,0,0,.6);
  color:#fff;border:0;
  width:40px;height:40px;
  border-radius:50%
}
.nav-btn.left{left:10px}
.nav-btn.right{right:10px}



</style>




{{-- ================= JS ================= --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>



document.addEventListener('DOMContentLoaded', () => {

  // ================= Gallery / Lightbox =================
 if (window.GLightbox) {
      GLightbox({ selector: '.glightbox', loop: true });
  }

  const images = @json(array_map(fn($i) => asset('storage/' . $i), $images));
  let index = 0;

  window.setImage = i => {
    index = i;
    mainImage.src = images[i];
    mainLink.href = images[i];
    document.querySelectorAll('.thumb-img')
      .forEach((el, idx) => el.classList.toggle('active', idx === i));
  }

  window.prevImage = () => setImage((index - 1 + images.length) % images.length);
  window.nextImage = () => setImage((index + 1) % images.length);

  // ================= Hitung Total Harga =================
  const base = {{ $product->price }};
  const totalPriceElem = document.getElementById('totalPrice');

  const calc = () => {
    let extra = 0;

    // Semua checkbox yang checked + opsi wajib yang disabled
    document.querySelectorAll('.option-checkbox').forEach(c => {
      if(c.checked) extra += parseInt(c.dataset.price);
    });

    let qty = parseInt(document.getElementById('qty')?.value || 1);
    if(totalPriceElem){
      totalPriceElem.innerText = 'Rp ' + ((base + extra) * qty).toLocaleString('id-ID');
    }
  }

  // Jalankan kalkulasi saat load halaman
  calc();

  // Update saat checkbox optional atau qty berubah
  document.querySelectorAll('.option-checkbox:not([disabled]), #qty')
    .forEach(el => el.addEventListener('input', calc));

  // ================= Swiper Related =================
  new Swiper('.related-swiper', {
    slidesPerView: 4,
    spaceBetween: 20,
    breakpoints: {
      320: { slidesPerView: 1 },
      768: { slidesPerView: 2 },
      992: { slidesPerView: 4 }
    }
  });

  // ================= Tombol Beli Sekarang =================
  const btnOrder = document.getElementById('btnOrder');
  if (!btnOrder) return;

  btnOrder.addEventListener('click', async () => {

    @auth('customer')

    // Ambil semua opsi yang dicentang (termasuk wajib)
    const options = [];
    document.querySelectorAll('.option-checkbox:checked').forEach(c => {
      options.push({
        name: c.closest('.form-check').querySelector('label').innerText.trim(),
        extra_price: parseInt(c.dataset.price)
      });
    });

    const qty = parseInt(document.getElementById('qty')?.value || 1);
    const note = document.querySelector('textarea')?.value || '';

    const extraTotal = options.reduce((sum, o) => sum + o.extra_price, 0);
    const subtotal = (base + extraTotal) * qty;

    try {
      const res = await fetch("{{ route('frontend.cart.add') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        credentials: 'same-origin',
        body: JSON.stringify({
          product_id: {{ $product->id }},
          qty: qty,
          note: note,
          options: options,
          subtotal: subtotal
        })
      });

      const text = await res.text();
      let data;
      try {
        data = JSON.parse(text);
      } catch(err){
        alert('Terjadi kesalahan: server tidak merespon JSON valid');
        return;
      }

    if(res.ok && data.success){
        const badge = document.querySelector('.js-cart-items-count');
        if(badge) badge.innerText = data.cart_count;

        // 🟢 Toast Success sebelum redirect
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            html: `Produk <strong>{{ $product->name }}</strong> berhasil ditambahkan ke keranjang`,
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            willClose: () => {
                window.location.href = "{{ route('frontend.cart.index') }}";
            }
        });

    } else {
        alert(data.error || data.message || `Gagal menambahkan produk. Status ${res.status}`);
    }

    } catch(err){
        alert('Terjadi kesalahan saat mengirim data, cek console untuk detail.');
        console.error(err);
    }

    @else
    // Belum login → redirect ke halaman login
    window.location.href = "{{ route('frontend.login') }}";
    @endauth

      });

});

</script>
@endsection