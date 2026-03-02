<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
            <th style="width: 15%">Name</th>
            <th style="width: 15%">Roles</th>
            <th style="width: 20%">Email</th>
            <th style="width: 15%">No.Tlpon</th>
            <th style="width: 20%">Created At</th>
            <th style="width: 20%">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
               <tr>
    <td>
        <div class="d-flex align-items-center">
            <img src="
                @if ($user->photo)
                    {{ asset('storage/users/' . $user->photo) }}
                @elseif ($user->roles == 'admin')
                    {{ asset('img/avatar/avatar-1.png') }}
                @else
                    {{ asset('img/avatar/avatar-2.png') }}
                @endif
            " alt="avatar" class="rounded-circle mr-2" width="40" height="40">
            <span>{{ $user->name }}</span>
        </div>
    </td>
    <td>{{ ucfirst($user->roles) }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->phone }}</td>
    <td>{{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}</td>
    <td>
        <div class="d-flex justify-content-center">
            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-info">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="ml-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger swal-confirm" data-name="{{ $user->name }}">
                    <i class="fas fa-times"></i> Delete
                </button>
            </form>
        </div>
    </td>
</tr>

            @endforeach
        </tbody>
    </table>

    <div class="float-right mt-2">
        {{ $users->appends(['name' => request('name'), 'per_page' => request('per_page')])->links() }}

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.swal-confirm').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                const name = this.getAttribute('data-name');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: `User "${name}" akan dihapus permanen.`,
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

                        // Delay submit sedikit supaya spinner terlihat
                        setTimeout(() => {
                            form.submit();
                        }, 100);
                    }
                });
            });
        });
    });
</script>
@endpush
