        @php
            $images = is_array($product->images) ? $product->images : [];

                // Hitung harga total: base price + semua opsi wajib / auto select
                $totalPrice = $product->price;
                if($product->options && $product->options->count() > 0){
                    foreach($product->options as $opt){
                        if($opt->is_required || $product->auto_select_all_custom){
                            foreach($opt->values as $val){
                                $totalPrice += $val->extra_price;
                            }
                        }
                    }
                }
        @endphp

        <a href="{{ route('frontend.products.show', $product) }}"
        class="text-decoration-none text-dark w-100 h-100 d-block">

            <div class="card product-card h-100 border-0 shadow-sm overflow-hidden">

                {{-- IMAGE --}}
                <div class="product-image-wrapper position-relative"
                    data-images='@json($images)'>

                    <img src="{{ !empty($images)
                        ? asset('storage/'.$images[0])
                        : asset('assets_frontend/assets/images/no-image.png') }}"
                        class="product-image"
                        alt="{{ $product->name }}">
                </div>

                {{-- CONTENT --}}
                <div class="card-body text-center d-flex flex-column px-3">

                    <span class="badge bg-primary mb-2 align-self-center">
                        {{ $product->category?->name }}
                    </span>

                    <h5 class="fw-bold mb-1 mt-1">
                        {{ $product->name }}
                    </h5>

                    <p class="text-muted mb-3">
                        Rp {{ number_format($totalPrice) }}
                    </p>

                    {{-- BUTTON --}}
                    <span class="btn btn-sm btn-outline-primary mt-auto">
                        Detail
                    </span>

                </div>
            </div>
        </a>

        {{-- ==================== STYLE ==================== --}}
        <style>
        /* CARD */
        .product-card {
            border-radius: 15px;
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,.12);
        }

        /* IMAGE WRAPPER */
        .product-image-wrapper {
            height: 320px;
            background: #f8f9fa;
            border-radius: 15px 15px 0 0;
            overflow: hidden;
        }

        /* IMAGE */
        .product-image {
            width: 100%;
            height: 100%;
            object-fit: contain; /* FOTO TIDAK TERPOTONG */
            transition: opacity .5s ease, transform .5s ease;
        }

        /* ZOOM ON HOVER */
        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        /* MOBILE */
        @media (max-width: 576px) {
            .product-image-wrapper {
                height: 240px;
            }
        }
        </style>

        {{-- ==================== SCRIPT ==================== --}}
        <script>
        document.addEventListener('DOMContentLoaded', () => {

        document.querySelectorAll('.product-image-wrapper').forEach(wrapper => {

            const images = JSON.parse(wrapper.dataset.images || '[]');
            if (images.length <= 1) return;

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
