@extends('layouts.app')

@section('title', 'Artikel')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Artikel</h1>
            <div class="section-header-button">
                <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">+ Tambah Baru</a>
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
                        <input type="text" class="form-control" placeholder="Cari judul..." id="search" name="title" autocomplete="off" value="{{ request('title') }}">
                        <div class="input-group-append">
                            <span class="btn btn-primary" id="btn-search">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Loading --}}
            <div id="article-loading" class="text-center my-4" style="display:none">
                <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                <div class="mt-2">Memuat data...</div>
            </div>

            {{-- Table --}}
            <div id="article-table">
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

// Render table & pagination
function renderTable(data) {
    if(data.data.length === 0){
        $('#article-table').html('<p class="text-center">Tidak ada artikel</p>');
        return;
    }

    let html = `<div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Slug</th>
                    <th>Layout</th>
                    <th>Gambar</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>`;

    data.data.forEach(article => {
        let images = article.images.length > 0 
            ? article.images.map(img => `<img src="/storage/${img.image_path}" width="80" class="img-thumbnail">`).join(' ')
            : '<span class="text-muted">Tidak ada</span>';

        let status = article.is_published ? 'Published' : 'Draft';
        let badge = article.is_published ? 'success' : 'secondary';

        html += `<tr>
            <td>${article.title}</td>
            <td>${article.slug}</td>
            <td>${article.layout}</td>
            <td>${images}</td>
            <td><span class="badge badge-${badge}">${status}</span></td>
            <td>${article.views}</td>
            <td>${new Date(article.created_at).toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' })}</td>
            <td>
                <a href="/admin/articles/${article.id}/edit" class="btn btn-sm btn-warning mr-1">Edit</a>
                <button class="btn btn-sm btn-danger btn-delete" data-id="${article.id}">Hapus</button>
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

    $('#article-table').html(html);
}

// Load data AJAX
function loadArticles(page = 1) {
    if(currentRequest) currentRequest.abort();
    $('#article-loading').show();

    currentRequest = $.ajax({
        url: "{{ route('admin.articles.index') }}",
        type: 'GET',
        data: {
            title: $('#search').val(),
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
        $('#article-loading').hide();
    });
}

// 🔹 Live search
$(document).on('keyup', '#search', function(){
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => loadArticles(1), 400);
});

// 🔹 Per page change
$(document).on('change', '#perPage', function(){
    loadArticles(1);
});

// 🔹 Pagination click
$(document).on('click', '#article-table .pagination a', function(e){
    e.preventDefault();
    let page = $(this).data('page');
    loadArticles(page);
});

// 🔹 Delete button
$(document).on('click', '.btn-delete', function(){
    let id = $(this).data('id');
    if(confirm('Yakin ingin menghapus artikel ini?')){
        $.ajax({
            url: `/admin/articles/${id}`,
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function(res){
                loadArticles();
                if(res.success){
                    toastr.success(res.message || 'Artikel berhasil dihapus');
                } else {
                    toastr.error(res.message || 'Gagal menghapus artikel');
                }
            },
            error: function(){
                toastr.error('Gagal menghapus artikel');
            }
        });
    }
});

// 🔹 Load default & tampilkan toastr dari session (create/edit/delete)
$(document).ready(function(){
    loadArticles();

    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
});
</script>
@endpush
