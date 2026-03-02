@extends('layouts.app')

@section('title','Daftar Order')

@section('main')
<div class="main-content">
<section class="section">
    <div class="section-header"><h1>Daftar Order</h1></div>

    <div class="section-body">
        @include('layouts.alert')

        <div class="card">
            <div class="card-body">
                {{-- Filter & Search --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <label for="perPage" class="mr-2">Tampilkan</label>
                        <select id="perPage" class="form-control d-inline-block w-auto">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    <span>data</span>
                </div>

                <div class="float-right">
                    <div class="input-group">
                       <input type="text" class="form-control" placeholder="Search..." id="search" name="search" autocomplete="off" value="{{ request('search') }}">

                        <div class="input-group-append">
                            <span class="btn btn-primary"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="order-table">
                @include('pages.orders.components.order-table')
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

function reloadOrderTable(url = "{{ route('orders.index') }}") {

    $('#order-table').html(`
        <div class="text-center my-4">
            <span class="spinner-border text-primary"></span>
            <div class="mt-2">Memuat data...</div>
        </div>
    `);

    $.get(url, {
        per_page: $('#perPage').val(),
        search: $('#search').val()
    })
    .done(function(res) {
        $('#order-table').html(res.html);
    })
    .fail(function() {
        $('#order-table').html(`
            <div class="text-danger text-center my-3">
                Gagal memuat data
            </div>
        `);
    });
}

// per page
$(document).on('change', '#perPage', function () {
    reloadOrderTable();
});

// live search dengan debounce
$('#search').on('keyup', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => reloadOrderTable(), 400);
});

// pagination AJAX
$(document).on('click', '#order-table .pagination a', function (e) {
    e.preventDefault();
    reloadOrderTable($(this).attr('href'));
});

</script>
@endpush


