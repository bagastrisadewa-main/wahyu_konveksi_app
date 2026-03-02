@extends('layouts.app')

@section('title', 'Navigation Menus')

@push('style')
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Navigation Menus</h1>
            <div class="section-header-button">
                <a href="{{ route('navigation-menus.create') }}" class="btn btn-primary"> + Tambah Baru</a>
            </div>
        </div>

        <div class="section-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <label for="perPage" class="mr-2">Tampilkan</label>
                    <select id="perPage" class="form-control d-inline-block w-auto">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>data</span>
                </div>

                <div class="float-right">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari menu..." id="search" autocomplete="off">
                        <div class="input-group-append">
                            <span class="btn btn-primary"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Loading --}}
            <div id="menu-loading" class="text-center my-4" style="display:none">
                <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                <div class="mt-2">Memuat data menu...</div>
            </div>

            {{-- Table --}}
            <div id="menu-table">
                <p class="text-center text-muted">Memuat data...</p>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
let currentQuery = '';
let currentPage = 1;
let currentPerPage = $('#perPage').val();
let currentRequest = null;

// Render tabel & pagination
function renderTable(data) {
    if(data.data.length === 0){
        $('#menu-table').html('<p class="text-center">Tidak ada menu</p>');
        return;
    }

    let html = `<div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Slug</th>
                    <th>URL</th>
                    <th>Parent</th>
                    <th>Urutan Menu</th>
                    <th>Active</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>`;

    data.data.forEach((menu, index) => {
        html += `<tr>
            <td>${index + 1 + (data.pagination.current_page-1)*data.pagination.per_page}</td>
            <td>${menu.title}</td>
            <td>${menu.slug}</td>
            <td>${menu.url || '-'}</td>
            <td>${menu.parent ? menu.parent.title : '-'}</td>
            <td>${menu.order}</td>
            <td>${menu.active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-secondary">Nonaktif</span>'}</td>

            <td>
                <a href="/navigation-menus/${menu.id}/edit" class="btn btn-sm btn-warning mr-1">Edit</a>
                <button class="btn btn-sm btn-danger btn-delete" data-id="${menu.id}">Hapus</button>
            </td>
        </tr>`;
    });

    html += `</tbody></table></div>`;

    // Pagination
    html += `<nav><ul class="pagination">`;
    for(let i=1;i<=data.pagination.last_page;i++){
        let active = i === data.pagination.current_page ? 'active' : '';
        html += `<li class="page-item ${active}">
            <a href="#" class="page-link" data-page="${i}">${i}</a>
        </li>`;
    }
    html += `</ul></nav>`;

    $('#menu-table').html(html);
}

// Load data AJAX
function loadMenus(query = '', page = 1, perPage = 10) {
    if(currentRequest) currentRequest.abort();
    $('#menu-loading').show();
    $('#menu-table').hide();

    currentRequest = $.ajax({
        url: "{{ route('navigation-menus.index') }}",
        type: 'GET',
        data: {
            title: query,
            page: page,
            per_page: perPage,
            ajax: true
        },
        dataType: 'json',
                    success: function(res){
                        renderTable({
                            data: res.data,
                            pagination: res.pagination
                        });
                    },
        error: function(){
            $('#menu-table').html('<div class="text-danger text-center">Gagal memuat data</div>');
        },
        complete: function(){
            $('#menu-loading').hide();
            $('#menu-table').fadeIn(150);
        }
    });
}

$(document).ready(function(){
    // Load default
    loadMenus();

    // Search debounce
    let typingTimer;
    $('#search').on('keyup', function(){
        clearTimeout(typingTimer);
        currentQuery = $(this).val().trim();
        currentPage = 1;
        typingTimer = setTimeout(function(){
            loadMenus(currentQuery, currentPage, currentPerPage);
        }, 400);
    });

    // Search icon click
    $('.input-group-append').on('click', function(){
        currentQuery = $('#search').val().trim();
        currentPage = 1;
        loadMenus(currentQuery, currentPage, currentPerPage);
    });

    // Per page change
    $('#perPage').on('change', function(){
        currentPerPage = $(this).val();
        currentPage = 1;
        loadMenus(currentQuery, currentPage, currentPerPage);
    });

    // Pagination click
    $(document).on('click', '.pagination a', function(e){
        e.preventDefault();
        let page = $(this).data('page');
        currentPage = page;
        loadMenus(currentQuery, currentPage, currentPerPage);
    });

    // Delete button AJAX
    $(document).on('click', '.btn-delete', function(){
        let id = $(this).data('id');
        if(confirm('Yakin ingin menghapus menu ini?')){
            $.ajax({
                url: `/navigation-menus/${id}`,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(res){
                    loadMenus(currentQuery, currentPage, currentPerPage);
                    toastr.success(res.message || 'Menu berhasil dihapus');
                },
                error: function(){
                    toastr.error('Gagal menghapus menu');
                }
            });
        }
    });

    // Tampilkan toast dari session
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif
    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
});
</script>
@endpush
