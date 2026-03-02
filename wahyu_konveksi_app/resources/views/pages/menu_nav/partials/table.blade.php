<table class="table table-bordered">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Slug</th>
            <th>URL</th>
            <th>Type</th>
            <th>Parent</th>
            <th>Order</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($navigationMenus as $menu)
            <tr>
                <td>{{ $menu->title }}</td>
                <td>{{ $menu->slug }}</td>
                <td>{{ $menu->url }}</td>
                <td>{{ ucfirst($menu->type) }}</td>
                <td>{{ $menu->parent?->title ?? '-' }}</td>
                <td>{{ $menu->order }}</td>
                <td>
                    @if($menu->active)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-secondary">Nonaktif</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('navigation-menus.edit', $menu) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('navigation-menus.destroy', $menu) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus menu ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada menu</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- <p class="text-info">
    Total menus fetched: 
    @if(method_exists($navigationMenus, 'total'))
        {{ $navigationMenus->total() }}
    @else
        {{ count($navigationMenus) }}
    @endif
</p> --}}


{{-- DEBUG --}}
{{-- Total hasil: {{ $navigationMenus->total() }} --}}

{{-- Tambahkan pagination --}}
{{-- <div class="mt-3">
    {{ $navigationMenus->links() }}
</div> --}}
