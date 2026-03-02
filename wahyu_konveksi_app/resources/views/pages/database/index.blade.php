@extends('layouts.app')

@section('title', 'Database')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Database Management</h1>
        </div>

        @include('layouts.alert')

        {{-- Tabs --}}
        <ul class="nav nav-tabs mb-3" id="dbTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="backup-tab" data-toggle="tab" href="#backup" role="tab">Backup / Restore</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="reset-tab" data-toggle="tab" href="#reset" role="tab">Reset Database</a>
            </li>
        </ul>

        <div class="tab-content" id="dbTabContent">
            <div class="tab-pane fade show active" id="backup" role="tabpanel">
                @include('pages.database.partials.backup_table')
            </div>
            <div class="tab-pane fade" id="reset" role="tabpanel">
                @include('pages.database.partials.reset_table')
            </div>
        </div>
    </section>
</div>
@endsection

<style>
.progress {
    background: #f1f3f6;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.08);
}

.progress-bar {
    transition: width 0.4s ease;
    font-weight: bold;
}
</style>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){

    function ajaxLoading(msg){
        Swal.fire({
            title: msg,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    // ===== Backup =====
    $('#backupForm').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Backup Database?',
            text: "Proses backup akan membuat file .sql baru.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Backup',
            cancelButtonText: 'Batal'
        }).then((result)=>{
            if(result.isConfirmed){
                ajaxLoading('Sedang backup...');
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(res){
                        Swal.close();
                        if(res.success){
                            Swal.fire('Sukses!', res.message, 'success').then(()=>location.reload());
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function(){
                        Swal.close();
                        Swal.fire('Error','Gagal backup database','error');
                    }
                });
            }
        });
    });

    // ===== Restore =====
    $(document).on('click', '.restore-btn', function(){
        let file = $(this).data('file');
        Swal.fire({
            title: 'Restore Database?',
            text: "Database lama akan diganti dengan backup ini.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Restore',
            cancelButtonText: 'Batal'
        }).then((result)=>{
            if(result.isConfirmed){
                ajaxLoading('Sedang restore...');
                $.post("{{ route('database.restore') }}", {backup_file: file, _token: "{{ csrf_token() }}"}, function(res){
                    Swal.close();
                    if(res.success){
                        Swal.fire('Sukses', res.message, 'success').then(()=>location.reload());
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                });
            }
        });
    });

    // ===== Reset =====
$('#resetForm').on('submit', function(e){
    e.preventDefault();

    Swal.fire({
        title: 'Reset Database?',
        text: "Semua data akan dihapus kecuali user admin!",
        icon: 'warning',
        input: 'password',
        inputLabel: 'Masukkan password admin',
        inputPlaceholder: 'Password',
        showCancelButton: true,
        confirmButtonText: 'Reset',
        cancelButtonText: 'Batal',
        preConfirm: (value) => {
            if (!value) {
                Swal.showValidationMessage('Password harus diisi');
            }
            return value;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            ajaxLoading('Sedang reset database...');

            $.ajax({
                url: "{{ route('database.reset') }}",
                type: "POST",
                data: {
                    password: result.value,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res){
                    Swal.close();
                    if(res.success){
                        Swal.fire('Sukses', res.message, 'success')
                            .then(()=> location.reload());
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                },
                error: function(xhr){
                    Swal.close();
                    console.error(xhr.responseText);
                    Swal.fire(
                        'Error',
                        xhr.responseJSON?.message ?? 'Reset gagal',
                        'error'
                    );
                }
            });
        }
    });
});


});



$(document).on('click', '.download-btn', function () {
    let file = $(this).data('file');

    Swal.fire({
        title: 'Download Backup?',
        text: file,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Download',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menyiapkan file...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // trigger download
            window.location.href = "{{ route('database.download', ':file') }}"
                .replace(':file', file);

            setTimeout(() => Swal.close(), 800);
        }
    });
});


// ===== Restore via Upload (PROGRESS VERSION) =====
$('#uploadRestoreForm').submit(function(e){
    e.preventDefault();

    Swal.fire({
        title: 'Restore Database?',
        text: "Database akan diganti dengan file ini.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Restore',
        cancelButtonText: 'Batal'
    }).then((result)=>{

        if(result.isConfirmed){

            let formData = new FormData(this);

            Swal.fire({
                title: 'Uploading...',
                html: `
                    <div style="margin-top:20px;">
                        <div class="progress" style="height:20px; border-radius:50px;">
                            <div id="uploadProgressBar"
                                 class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                 style="width:0%">
                            </div>
                        </div>
                        <div id="uploadPercent"
                             style="margin-top:10px; font-weight:600;">
                             0%
                        </div>
                    </div>
                `,
                allowOutsideClick: false,
                showConfirmButton: false
            });

            $.ajax({
                url: "{{ route('database.restore') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                xhr: function () {
                    let xhr = new window.XMLHttpRequest();

                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {

                            let percent = Math.round((evt.loaded / evt.total) * 100);

                            $('#uploadProgressBar').css('width', percent + '%');
                            $('#uploadPercent').text(percent + '%');
                        }
                    }, false);

                    return xhr;
                },
                success: function(res){

                    if(res.success){

                        $('#uploadProgressBar')
                            .removeClass('bg-success')
                            .addClass('bg-primary')
                            .css('width','100%');

                        $('#uploadPercent').text('Finalizing restore...');

                        setTimeout(()=>{
                            Swal.fire({
                                icon: 'success',
                                title: 'Restore Berhasil',
                                text: res.message
                            }).then(()=> location.reload());
                        }, 800);

                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                },
                error: function(xhr){
                    Swal.fire(
                        'Error',
                        xhr.responseJSON?.message ?? 'Restore gagal',
                        'error'
                    );
                }
            });
        }
    });
});


</script>
@endpush
