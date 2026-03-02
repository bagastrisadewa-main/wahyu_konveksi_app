@extends('layouts.app')

@section('title', 'Users')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Users</h1>
                <div class="section-header-button">
                    <a href="{{ route('user.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Users</a></div>
                    <div class="breadcrumb-item">All Users</div>
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
                                    <!-- Per Page Dropdown - kiri -->
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

                                    <!-- Search Input - kanan -->
                                    <div class="float-right">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search..." id="search" name="name" autocomplete="off">
                                            <div class="input-group-append">
                                                <span class="btn btn-primary"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <!-- Table + Pagination Container -->
                                <div id="user-table">
                                     @include('pages.users.partials.table')
                                    </div>

                                </div>
                                <!-- End user-table -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

  <!-- Live Search + Pagination + Per Page Script -->
<script>
    $(document).ready(function () {
        let currentQuery = '';
        let currentPage = 1;
        let currentPerPage = $('#perPage').val();

        function fetchData(query = '', page = 1, perPage = 10) {
            // Jika query kosong, ubah ke null agar filter dihapus
            if (!query || query.length === 0) {
                query = null;
            }

            $('#user-table').html('<div class="text-center my-3"><span class="spinner-border text-primary"></span> Loading...</div>');

            $.ajax({
                url: "{{ route('user.index') }}",
                type: "GET",
                data: {
                    name: query,
                    page: page,
                    per_page: perPage
                },
                success: function (response) {
                    $('#user-table').html(response.html);

                    // Update tracking
                    currentQuery = query ?? ''; // update ke string kosong jika null
                    currentPage = page;
                    currentPerPage = perPage;
                },
                error: function (xhr) {
                    $('#user-table').html('<div class="text-danger text-center my-3">Gagal memuat data</div>');
                }
            });
        }

        // Live search ketika diketik
        $('#search').on('keyup', function () {
            currentQuery = $(this).val().trim();
            currentPage = 1;
            fetchData(currentQuery, currentPage, currentPerPage);
        });

        // Per page dropdown
        $('#perPage').on('change', function () {
            currentPerPage = $(this).val();
            currentPage = 1;
            fetchData(currentQuery, currentPage, currentPerPage);
        });

        // Pagination link click
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();

            const url = $(this).attr('href');
            const page = new URLSearchParams(url.split('?')[1]).get('page');

            fetchData(currentQuery, page, currentPerPage);
        });
    });
</script>



@endpush
