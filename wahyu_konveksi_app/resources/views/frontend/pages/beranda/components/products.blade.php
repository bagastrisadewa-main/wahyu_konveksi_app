<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold display-5">Produk <span class="text-primary">Unggulan</span></h2>
        <p class="text-muted fs-4">Pilihan produk terbaik dari kami</p>
    </div>

    <div class="row g-4">
        @forelse($products as $product)
            @php
                $images = is_array($product->images) ? $product->images : [];
                $totalPrice = $product->price;
            @endphp

            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                <div class="card product-card h-100 border-0 shadow-sm overflow-hidden w-100">

                    <a href="{{ route('frontend.products.show', $product->slug) }}" class="text-decoration-none text-dark">
                        <div class="product-image-wrapper position-relative" data-images='@json($images)'>
                            <img src="{{ !empty($images) ? asset('storage/'.$images[0]) : asset('assets_frontend/assets/images/no-image.png') }}"
                                 class="product-image"
                                 alt="{{ $product->name }}"
                                 loading="lazy">
                        </div>
                    </a>

                    <button type="button"
                            class="btn-add-cart"
                            data-product-id="{{ $product->id }}"
                            data-logged-in="{{ auth('customer')->check() ? '1' : '0' }}"
                            title="Tambah ke keranjang">
                        <i class="fa fa-shopping-cart"></i>
                    </button>

                    <a href="{{ route('frontend.products.show', $product->slug) }}" class="text-decoration-none text-dark">
                        <div class="card-body text-center d-flex flex-column px-3 py-4">
                            <span class="badge bg-primary mb-3">{{ $product->category?->name }}</span>
                            <h5 class="fw-bold mb-2 product-title">{{ $product->name }}</h5>
                            <p class="text-muted mb-3 fs-5">Rp {{ number_format($totalPrice,0,',','.') }}</p>
                            <span class="btn btn-sm btn-outline-primary mt-auto py-2 px-4">Detail</span>
                        </div>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted fs-5">
                Produk belum tersedia
            </div>
        @endforelse
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('frontend.products.index') }}" class="btn btn-primary btn-lg py-3 px-5">
            Lihat Semua Produk
        </a>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.product-image-wrapper').forEach(wrapper => {
        const images = JSON.parse(wrapper.dataset.images || '[]');
        if (images.length <= 1) return;
        const img = wrapper.querySelector('.product-image');
        let index = 0;
        setInterval(() => {
            index = (index + 1) % images.length;
            img.classList.add('fade-out');
            setTimeout(() => {
                img.src = "{{ asset('storage') }}/" + images[index];
                img.classList.remove('fade-out');
            }, 300);
        }, 5000);
    });

    document.querySelectorAll('.btn-add-cart').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (this.dataset.loggedIn !== '1') {
                window.location.href = "{{ route('frontend.login') }}";
                return;
            }

            const productId = this.dataset.productId;
            const button = this;
            const originalIcon = button.innerHTML;
            button.disabled = true;
            button.classList.add('is-loading');
            button.innerHTML = '<i class="fa fa-spinner"></i>';

            fetch("{{ route('frontend.cart.add') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ product_id: productId, qty: 1 })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    button.innerHTML = '<i class="fa fa-check"></i>';
                    button.classList.add('is-success');

                    Toastify({
                        text: 'Ditambahkan ke keranjang',
                        duration: 1800,
                        gravity: 'top',
                        position: 'right',
                        backgroundColor: '#28a745',
                        close: true,
                    }).showToast();

                    const cartBadgeDesktop = document.getElementById('cart-count-badge-desktop');
                    const cartBadgeMobile = document.getElementById('cart-count-badge-mobile');
                    if (data.cartCount !== undefined) {
                        if (cartBadgeDesktop) {
                            cartBadgeDesktop.innerText = data.cartCount;
                            cartBadgeDesktop.style.display = 'inline-flex';
                        }
                        if (cartBadgeMobile) {
                            cartBadgeMobile.innerText = data.cartCount;
                            cartBadgeMobile.style.display = 'inline-flex';
                        }
                    }

                    setTimeout(() => {
                        button.innerHTML = originalIcon;
                        button.classList.remove('is-success');
                    }, 1200);

                } else {
                    button.innerHTML = originalIcon;
                    Toastify({
                        text: 'Produk gagal ditambahkan ke keranjang.',
                        duration: 2000,
                        gravity: 'top',
                        position: 'right',
                        backgroundColor: '#dc3545',
                        close: true,
                    }).showToast();
                }
            })
            .catch(() => {
                button.innerHTML = originalIcon;
                Toastify({
                    text: 'Terjadi kesalahan. Coba lagi.',
                    duration: 2000,
                    gravity: 'top',
                    position: 'right',
                    backgroundColor: '#dc3545',
                    close: true,
                }).showToast();
            })
            .finally(() => {
                button.disabled = false;
                button.classList.remove('is-loading');
            });
        });
    });

});
</script>

<style>
.product-card {
    position: relative;
    border-radius: 20px !important;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.12) !important;
}

.product-image-wrapper {
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    background: #f8f9fa;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: opacity 0.4s ease, transform 0.4s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-image.fade-out {
    opacity: 0;
}

.btn-add-cart {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    background: #fff;
    color: #212529;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    z-index: 5;
    transition: background 0.2s ease, color 0.2s ease, transform 0.15s ease;
}

.btn-add-cart:hover {
    background: #212529;
    color: #fff;
    transform: scale(1.1);
}

.btn-add-cart:active {
    transform: scale(0.85);
}

.btn-add-cart.is-loading i {
    animation: cartSpin 0.6s linear infinite;
}

.btn-add-cart.is-success {
    background: #28a745 !important;
    color: #fff !important;
}

@keyframes cartSpin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.product-title {
    font-size: 1.1rem;
    min-height: 2.6rem;
}

.product-card .badge {
    font-size: 0.9rem;
    padding: 0.5em 0.9em;
    border-radius: 20px;
}

.product-card .btn-outline-primary {
    border-radius: 30px;
    font-size: 0.9rem;
}
</style>