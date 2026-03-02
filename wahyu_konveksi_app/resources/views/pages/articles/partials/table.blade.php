<div class="table-responsive">
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
        <tbody>

            {{-- DEBUG --}}
            {{-- <tr>
                <td colspan="99" style="background:#ffeeba;padding:6px;">
                    DEBUG TOTAL: {{ $articles->total() }}
                </td>
            </tr> --}}

            {{-- INFO SEARCH --}}
            {{-- @if(!empty($keyword))
            <tr>
                <td colspan="99" class="text-muted small">
                    🔍 Menampilkan hasil pencarian:
                    <b>"{{ $keyword }}"</b>
                    ({{ $articles->total() }} data ditemukan)
                </td>
            </tr>
            @endif --}}

            @forelse ($articles as $article)
            <tr>
                <td>{{ $article->title }}</td>
                <td>{{ $article->slug }}</td>
                <td>{{ $article->layout }}</td>
                <td>
                    @forelse($article->images as $img)
                        <img src="{{ asset('storage/' . $img->image_path) }}" width="80" class="img-thumbnail">
                    @empty
                        <span class="text-muted">Tidak ada</span>
                    @endforelse
                </td>
                <td>
                    <span class="badge badge-{{ $article->is_published ? 'success' : 'secondary' }}">
                        {{ $article->is_published ? 'Published' : 'Draft' }}
                    </span>
                </td>
                <td>{{ $article->views }}</td>
                <td>{{ $article->created_at->translatedFormat('d F Y') }}</td>
                <td>...</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada artikel</td>
            </tr>
            @endforelse

        </tbody>
    </table>
</div>

<div class="float-right mt-2">
  {{ $articles->links('pagination::bootstrap-4') }}
</div>

{{-- 🔹 Tambahkan log untuk debug --}}
{{-- <script>
    console.log('ARTICLES PARTIAL:', {
        count: {{ $articles->count() }},
        total: {{ $articles->total() }},
        firstItem: {{ $articles->firstItem() }},
        lastItem: {{ $articles->lastItem() }}
    });
</script> --}}