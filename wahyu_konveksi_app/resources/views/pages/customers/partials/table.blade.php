<div class="table-responsive">
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Status</th>
            <th>Terdaftar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($customers as $customer)
        <tr>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->phone }}</td>
            <td>
                <span class="badge {{ $customer->is_active ? 'badge-success' : 'badge-danger' }}">
                    {{ $customer->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </td>
            <td>{{ $customer->created_at->format('d M Y') }}</td>
            <td>
                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-info">
                    Edit
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Data tidak ditemukan</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="float-right">
    {{ $customers->links() }}
</div>
</div>
