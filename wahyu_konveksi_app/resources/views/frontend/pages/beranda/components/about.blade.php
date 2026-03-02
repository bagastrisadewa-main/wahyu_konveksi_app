@if($about)
<section class="about-us container py-5 mb-5">
    <div class="row align-items-stretch">
        
        <!-- Gambar kiri -->
        <div class="about-image col-md-5 mb-4 mb-md-0 text-center">
            <img loading="lazy" 
                 src="{{ asset('storage/' . $about->image) }}" 
                 alt="{{ $about->title }}" 
                 class="img-fluid rounded shadow h-100" 
                 style="max-width:100%; height:100%; object-fit:cover; border-radius:15px;">
        </div>

        <!-- Konten kanan -->
        <div class="about-content col-md-7 ps-md-4 d-flex flex-column justify-content-between">
            
            {{-- Banner Title (atas) --}}
            @if($about->banner_title)
            <div>
                <p class="text-primary fw-semibold mb-2" 
                   style="font-size:1.1rem; border-bottom:2px solid #0d6efd; display:inline-block;">
                    {{ $about->banner_title }}
                </p>
            </div>
            @endif

            {{-- Judul & Deskripsi + Tombol (tengah) --}}
            <div class="d-flex flex-column justify-content-center flex-grow-1">
                <h2 class="fw-bold text-start" style="font-size:2rem; line-height:1.2; transition:color 0.3s;">
                    {{ $about->title }}
                </h2>
                <p class="text-start" style="font-size:1.2rem; line-height:1.6; margin-top:1rem;">
                    {{ $about->description }}
                </p>

                {{-- Tombol Read More langsung di bawah deskripsi --}}
                {{-- Tombol Read More langsung di bawah deskripsi --}}
                    <div class="mt-4 text-start">
                          <a href="{{ route('tentang.kami') }}"
                        class="btn btn-primary d-inline-flex align-items-center justify-content-center w-auto px-3 py-2"
                        style="border-radius:50px; transition:transform 0.3s;">
                        Tentang Kami
                        </a>
                    </div>
            </div>

        </div>
    </div>
</section>
@endif
