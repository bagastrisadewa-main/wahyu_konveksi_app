@extends('layouts.app')

@section('title', 'Kategori')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kategori</h1>
            <div class="section-header-button">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Tambah Baru</a>
            </div>
        </div>

        <div class="section-body">

            {{-- Search & per page --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <label for="perPage" class="mr-2">Tampilkan</label>
                    <select id="perPage" class="form-control d-inline-block w-auto">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </div>

                <div>
                    <div class="input-group w-auto">
                        <input type="text" class="form-control" placeholder="Cari kategori..." id="search" name="name" autocomplete="off" value="{{ request('name') }}">
                        <div class="input-group-append">
                            <span class="btn btn-primary" id="btn-search"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Loading --}}
            <div id="category-loading" class="text-center my-4" style="display:none">
                <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                <div class="mt-2">Memuat data...</div>
            </div>

            {{-- Table --}}
            <div id="category-table">
                {{-- Akan di-render JS --}}
            </div>

        </div>
    </section>
</div>
@endsection

@push('style')
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@push('scripts')
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
let typingTimer;
let currentRequest = null;

// Render tabel & pagination
function renderTable(data) {
    if(data.data.length === 0){
        $('#category-table').html('<p class="text-center">Tidak ada kategori</p>');
        return;
    }

    let html = `<div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Gambar</th>
                    <th>Dibuat Pada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>`;

    data.data.forEach((category, index) => {
        let images = category.image ? JSON.parse(category.image) : [];
        let imgHtml = images.length > 0 ? `<img src="/storage/${images[0]}" width="60" class="rounded">` : '<span class="text-muted">-</span>';

        html += `<tr>
            <td>${index + 1 + (data.pagination.current_page-1)*data.pagination.per_page}</td>
            <td>${category.name}</td>
            <td>${category.slug}</td>
            <td>${imgHtml}</td>
            <td>${new Date(category.created_at).toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' })}</td>
            <td>
                <a href="/admin/categories/${category.id}/edit" class="btn btn-sm btn-warning mr-1">Edit</a>
                <button class="btn btn-sm btn-danger btn-delete" data-id="${category.id}">Hapus</button>
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

    $('#category-table').html(html);
}

// Load data AJAX
function loadCategories(page = 1) {
    if(currentRequest) currentRequest.abort();
    $('#category-loading').show();

    currentRequest = $.ajax({
        url: "{{ route('admin.categories.index') }}",
        type: 'GET',
        data: {
            name: $('#search').val(),
            per_page: $('#perPage').val(),
            page: page,
            ajax: true
        },
        dataType: 'json'
    })
    .done(function(res){
        renderTable(res);
    })
    .always(function(){
        $('#category-loading').hide();
    });
}

// 🔹 Live search
$(document).on('keyup', '#search', function(){
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => loadCategories(1), 400);
});

// 🔹 Per page change
$(document).on('change', '#perPage', function(){
    loadCategories(1);
});

// 🔹 Pagination click
$(document).on('click', '#category-table .pagination a', function(e){
    e.preventDefault();
    let page = $(this).data('page');
    loadCategories(page);
});

// 🔹 Delete button
$(document).on('click', '.btn-delete', function(){
    let id = $(this).data('id');
    if(confirm('Yakin ingin menghapus kategori ini?')){
        $.ajax({
            url: `/admin/categories/${id}`,
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function(res){
                loadCategories();
                if(res.success){
                    toastr.success(res.message);
                } else {
                    toastr.error(res.message);
                }
            },
            error: function(){
                toastr.error('Gagal menghapus kategori');
            }
        });
    }
});

// 🔹 Load default & tampilkan toastr dari session (create/edit/delete)
$(document).ready(function(){
    loadCategories();

    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
});
</script>
@endpush
