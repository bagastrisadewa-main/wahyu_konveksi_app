@extends('layouts.app')

@section('title', 'Aktivitas')

@push('styles')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Aktivitas Saya</h1>
        </div>

        <div class="section-body">
            @if ($logs->isEmpty())
                <p class="text-muted">Belum ada aktivitas.</p>
            @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="activityTable" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Deskripsi</th>
                            <th>Modul</th>
                            <th>Aksi</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $index => $log)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $log->description }}</td>
                            <td>
                                <span class="badge badge-info">{{ $log->module ?? '-' }}</span>
                            </td>
                            <td>
                                @php
                                    $action = strtolower($log->action ?? 'lainnya');
                                @endphp
                                @if ($action === 'create')
                                    <span class="badge badge-success">Create</span>
                                @elseif ($action === 'update')
                                    <span class="badge badge-warning">Update</span>
                                @elseif ($action === 'delete')
                                    <span class="badge badge-danger">Delete</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($action) }}</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </section>
</div>
@endsection

@push('scripts')
    {{-- DataTables JS --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#activityTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "›",
                        previous: "‹"
                    },
                    zeroRecords: "Tidak ditemukan aktivitas",
                }
            });
        });
    </script>
@endpush
