<table class="table table-bordered">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Sub Judul</th>
            <th>Button</th>
            <th>Link</th>
            <th>Gambar</th>
            <th>Urutan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sliders as $slider)
            <tr>
                <td>{{ $slider->title }}</td>
                <td>{{ $slider->subtitle ?? '-' }}</td>
                <td>{{ $slider->button_text ?? '-' }}</td>
                <td>{{ $slider->button_link ?? '-' }}</td>
                <td>
                    @if($slider->image)
                        <img src="{{ asset('storage/'.$slider->image) }}" width="80">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>{{ $slider->order }}</td>
                <td>
                    @if($slider->is_active)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-secondary">Nonaktif</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('sliders.edit',$slider->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('sliders.destroy',$slider->id) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus slider ini?')"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada slider</td>
            </tr>
        @endforelse
    </tbody>
</table>
