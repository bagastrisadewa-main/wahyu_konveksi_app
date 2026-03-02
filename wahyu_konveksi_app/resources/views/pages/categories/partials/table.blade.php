<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Nama Kategori</th>
            <th>Slug</th>
            <th>Gambar</th>
            <th>Dibuat Pada</th>
            <th width="150">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>
                    @php $images = json_decode($category->image, true) ?? []; @endphp
                    @if(count($images))
                        <img src="{{ asset('storage/'.$images[0]) }}" width="60" class="rounded">
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>{{ $category->created_at->translatedFormat('d F Y') }}</td>
                <td>
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">
                        Edit
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}"
                          method="POST" class="d-inline swal-confirm" data-name="{{ $category->name }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">Data kosong</td></tr>
        @endforelse
        </tbody>
    </table>

    {{-- Tampilkan pagination hanya jika $categories adalah Paginator --}}
    @if(method_exists($categories, 'links'))
        {{ $categories->links() }}
    @endif
</div>


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).on('click', '.swal-confirm', function (e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const name = $(this).data('name');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: `Kategori "${name}" akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });

                    setTimeout(() => {
                        form.submit();
                    }, 300);
                }
            });
        });
    });
</script>
@endpush
