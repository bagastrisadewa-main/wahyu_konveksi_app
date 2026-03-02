<div class="card mb-4 shadow-sm rounded-4 p-3">
    <h6 class="fw-bold mb-3">Filter Produk</h6>

    <form method="GET"
          action="{{ route('frontend.products.index') }}"
          class="d-flex flex-column gap-2">

        {{-- ================= KATEGORI ================= --}}
        <label class="fw-semibold">Kategori</label>

        <div class="d-flex flex-wrap gap-2 mb-2">

            {{-- ALL CATEGORY --}}
            <button type="submit"
                    class="btn btn-outline-primary btn-sm
                    {{ !request('category') ? 'active' : '' }}">
                All
            </button>

            {{-- 6 KATEGORI UTAMA --}}
            @foreach($categories->take(6) as $category)
                <button type="submit"
                        name="category"
                        value="{{ $category->id }}"
                        class="btn btn-outline-primary btn-sm
                        {{ request('category') == $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </button>
            @endforeach

            {{-- NEXT / LAINNYA --}}
            @if($categories->count() > 5)
                <button type="button"
                        class="btn btn-outline-secondary btn-sm"
                        data-bs-toggle="collapse"
                        data-bs-target="#moreCategories">
                    Next →
                </button>
            @endif
        </div>

        {{-- KATEGORI LANJUTAN --}}
        @if($categories->count() > 6)
            <div class="collapse" id="moreCategories">
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @foreach($categories->slice(6) as $category)
                        <button type="submit"
                                name="category"
                                value="{{ $category->id }}"
                                class="btn btn-outline-primary btn-sm
                                {{ request('category') == $category->id ? 'active' : '' }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ================= SLIDER HARGA ================= --}}
        @include('frontend.products.components.slider-price')

        <button type="submit" class="btn btn-primary btn-sm mt-3">
            Terapkan Filter
        </button>

        {{-- RESET --}}
        @if(request()->hasAny(['category', 'min_price', 'max_price']))
            <a href="{{ route('frontend.products.index') }}"
               class="btn btn-outline-secondary btn-sm mt-1">
                Reset Filter
            </a>
        @endif
    </form>
</div>
