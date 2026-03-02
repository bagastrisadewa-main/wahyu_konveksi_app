@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible show fade auto-dismiss-alert">

        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            <p>{{ $message }}</p>
        </div>
    </div>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.querySelector('.auto-dismiss-alert');

        if (alert) {
            // Setelah 3 detik, fade out
            setTimeout(() => {
                alert.classList.remove('show');
                alert.classList.add('fade');
            }, 3000);

            // Setelah fade out selesai (500ms), hapus dari DOM
            setTimeout(() => {
                alert.remove();
            }, 3500);
        }
    });
</script>
@endpush
