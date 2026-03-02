<table class="table table-bordered">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Gambar</th>
            <th>Banner</th>
            <th>Banner Title</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($abouts as $about)
        <tr>
            <td>{{ $about->title }}</td>
            <td>{{ Str::limit($about->description, 50) }}</td>
            <td>
                @if($about->image)
                    <img src="{{ asset('storage/'.$about->image) }}" width="80">
                @else
                    <span class="text-muted">No Image</span>
                @endif
            </td>
            <td>
                @if($about->banner_image)
                    <img src="{{ asset('storage/'.$about->banner_image) }}" width="80">
                @else
                    <span class="text-muted">No Banner</span>
                @endif
            </td>
            <td>{{ $about->banner_title ?? '-' }}</td>
            <td>
                <a href="{{ route('about.edit',$about->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                <form action="{{ route('about.destroy',$about->id) }}" method="POST" style="display:inline-block">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Belum ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $abouts->links() }}
</div>
