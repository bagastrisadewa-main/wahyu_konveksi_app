@extends('layouts.app')

@section('title', 'Customer')

@section('main')
<div class="main-content">
<section class="section">
    <div class="section-header">
        <h1>Data Customer</h1>
    </div>

    <div class="section-body">
        @include('layouts.alert')

        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <select id="perPage" class="form-control w-auto">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>

                    <input type="text" id="search" class="form-control w-25" placeholder="Cari customer...">
                </div>

                {{-- LOADING --}}
                    <div id="customer-loading" class="text-center my-4" style="display:none">
                        <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                        <div class="mt-2">Memuat data...</div>
                    </div>


                <div id="customer-table">
                    @include('pages.customers.partials.table')
                </div>

            </div>
        </div>
    </div>
</section>
</div>
@endsection

@push('scripts')
<script>
$(function () {

    let keyword = '';
    let perPage = $('#perPage').val();

    function loadData(page = 1) {

        $('#customer-loading').show();
        $('#customer-table').hide();

        $.get("{{ route('customers.index') }}", {
            keyword: keyword,
            per_page: perPage,
            page: page
        })
        .done(function (res) {
            $('#customer-table').html(res.html);
        })
        .fail(function () {
            alert('Gagal memuat data customer');
        })
        .always(function () {
            $('#customer-loading').hide();
            $('#customer-table').fadeIn(150);
        });
    }

    // 🔍 SEARCH
    $('#search').on('keyup', function () {
        keyword = $(this).val();
        loadData();
    });

    // 📄 PER PAGE
    $('#perPage').on('change', function () {
        perPage = $(this).val();
        loadData();
    });

    // 📑 PAGINATION
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        loadData(page);
    });

});
</script>
@endpush
