@extends('layouts.app')

@section('title', 'Slider Images')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Slider Images</h1>
                <div class="section-header-button">
                    <a href="{{ route('sliders.create') }}" class="btn btn-primary">+ Tambah Baru</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Slider</a></div>
                    <div class="breadcrumb-item">All Sliders</div>
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
                                            <input type="text" class="form-control" placeholder="Cari slider..." id="search" name="title" autocomplete="off">
                                            <div class="input-group-append">
                                                <span class="btn btn-primary"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="slider-table">
                                    @include('pages.slider.partials.table')
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
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            let currentQuery = '';
            let currentPage = 1;
            let currentPerPage = $('#perPage').val();

            function fetchData(query = '', page = 1, perPage = 10) {
                if (!query || query.length === 0) {
                    query = null;
                }

                $('#slider-table').html('<div class="text-center my-3"><span class="spinner-border text-primary"></span> Loading...</div>');

                $.ajax({
                    url: "{{ route('sliders.index') }}",
                    type: "GET",
                    data: {
                        title: query,
                        page: page,
                        per_page: perPage
                    },
                    success: function (response) {
                        $('#slider-table').html(response.html);
                        currentQuery = query ?? '';
                        currentPage = page;
                        currentPerPage = perPage;
                    },
                    error: function () {
                        $('#slider-table').html('<div class="text-danger text-center my-3">Gagal memuat data</div>');
                    }
                });
            }

            $('#search').on('keyup', function () {
                currentQuery = $(this).val().trim();
                currentPage = 1;
                fetchData(currentQuery, currentPage, currentPerPage);
            });

            $('#perPage').on('change', function () {
                currentPerPage = $(this).val();
                currentPage = 1;
                fetchData(currentQuery, currentPage, currentPerPage);
            });

            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                const url = $(this).attr('href');
                const page = new URLSearchParams(url.split('?')[1]).get('page');
                fetchData(currentQuery, page, currentPerPage);
            });
        });
    </script>
@endpush
