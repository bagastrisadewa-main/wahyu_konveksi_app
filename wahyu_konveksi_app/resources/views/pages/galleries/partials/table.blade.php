<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Dibuat Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($galleries as $gallery)
                <tr>
                    <td>{{ $gallery->title }}</td>
                        <td>
                            @if($gallery->category)
                                {{ $gallery->category->name }}
                            @else
                                <span class="badge badge-warning">Tanpa Kategori</span>
                            @endif
                        </td>
                        
                        <td>
                            @if(count($gallery->images))
                                @foreach($gallery->images as $img)
                                    <img src="{{ asset('storage/'.$img) }}"
                                        width="60"
                                        class="img-thumbnail mr-1 mb-1">
                                @endforeach
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>

                    <td>{{ \Illuminate\Support\Str::limit($gallery->description, 30) }}</td>
                    <td>
                        <span class="badge badge-{{ $gallery->status == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($gallery->status) }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($gallery->created_at)->translatedFormat('d F Y') }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('galleries.edit', $gallery->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('galleries.destroy', $gallery->id) }}" method="POST" class="ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger swal-confirm" data-name="{{ $gallery->title }}">
                                    <i class="fas fa-times"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada gallery ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="float-right mt-2">
    {{ $galleries->appends(['title' => request('title'), 'per_page' => request('per_page')])->links() }}
</div>
