@extends('layouts.app')

@section('title', 'Produk')

@push('style')
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Produk</h1>

            <div class="section-header-button">
                <a href="{{ route('product.create') }}" class="btn btn-primary">
                    + Tambah Produk
                </a>
            </div>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="#">Dashboard</a>
                </div>
                <div class="breadcrumb-item">Produk</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            {{-- FILTER --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <label class="mr-2">Tampilkan</label>
                                    <select id="perPage" class="form-control d-inline-block w-auto">
                                        @foreach([10,20,50,100] as $val)
                                            <option value="{{ $val }}" {{ request('per_page')==$val?'selected':'' }}>
                                                {{ $val }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span>data</span>
                                </div>

                                <div>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                               placeholder="Cari nama / kategori..."
                                               id="search"
                                               value="{{ request('name') }}">
                                        <div class="input-group-append">
                                            <span class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="product-table">
                                @include('pages.products.partials.table')
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
let typingTimer;

function reloadTable(url = "{{ route('product.index') }}") {

    // 🔥 TAMPILKAN LOADING
    $('#product-table').html(`
        <div class="text-center my-4">
            <span class="spinner-border text-primary"></span>
            <div class="mt-2">Memuat data...</div>
        </div>
    `);

    $.get(url, {
        per_page: $('#perPage').val(),
        name: $('#search').val()
    })
    .done(function (res) {
        $('#product-table').html(res.html);
    })
    .fail(function () {
        $('#product-table').html(`
            <div class="text-danger text-center my-3">
                Gagal memuat data
            </div>
        `);
    });
}

// per page
$(document).on('change', '#perPage', function () {
    reloadTable();
});

// live search (debounce seperti order)
$('#search').on('keyup', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => reloadTable(), 400);
});

// pagination AJAX
$(document).on('click', '#product-table .pagination a', function (e) {
    e.preventDefault();
    reloadTable($(this).attr('href'));
});
</script>
@endpush

