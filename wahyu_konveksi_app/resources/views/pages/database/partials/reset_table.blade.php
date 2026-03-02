<div class="card">
    <div class="card-header"><h4>Reset Database</h4></div>
    <div class="card-body">
        <p>Reset database akan menghapus semua data kecuali user admin.</p>
        <form id="resetForm">
            @csrf
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Reset Database</button>
        </form>
    </div>
</div>
