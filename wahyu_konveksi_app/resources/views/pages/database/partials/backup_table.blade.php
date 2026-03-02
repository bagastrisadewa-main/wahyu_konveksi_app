<div class="card">
    <div class="card-header"><h4>Backup & Restore Database</h4></div>
    <div class="card-body">
        <form id="backupForm" action="{{ route('database.backup') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary mb-3"><i class="fas fa-database"></i> Backup Sekarang</button>
        </form>

        <h5>Restore dari File Upload:</h5>

            <form id="uploadRestoreForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="file" name="backup_upload" class="form-control" accept=".sql" required>
                </div>
                <button type="submit" class="btn btn-warning mt-2">
                    <i class="fas fa-upload"></i> Upload & Restore
                </button>
            </form>

            <hr>

        <h5>Daftar Backup:</h5>
        <table class="table table-striped">
            <thead>
                <tr><th>Nama File</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse ($backups as $file)
                <tr>
                    <td>{{ basename($file) }}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm restore-btn"
                                data-file="{{ $file }}">
                            <i class="fas fa-upload"></i> Restore
                        </button>
                    <button type="button"
                            class="btn btn-info btn-sm download-btn"
                            data-file="{{ basename($file) }}">
                        <i class="fas fa-download"></i> Download
                    </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="2" class="text-center text-muted">Belum ada backup.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
