@extends('layouts.app')

@section('title', 'Pengaturan Aplikasi')




@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengaturan Aplikasi</h1>
        </div>

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

            <form id="setting-form" action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
            {{-- <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data"> --}}
                @csrf

                {{-- 🔹 Informasi Aplikasi --}}
                <div class="card mb-4">
                    <div class="card-header"><h4>Informasi Umum</h4></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Aplikasi</label>
                            <input type="text" name="store_name" class="form-control"
                                   value="{{ $settings['store_name'] ?? 'Yans POS' }}">
                        </div>

                        <div class="form-group">
                            <label>Teks Footer</label>
                            <input type="text" name="store_footer_text" class="form-control"
                                   value="{{ $settings['store_footer_text'] ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Alamat Toko (PDF/Print)</label>
                            <input type="text" name="store_address" class="form-control"
                                   value="{{ $settings['store_address'] ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Nomor WhatsApp</label>
                            <input type="number" name="store_phone" class="form-control"
                                   pattern="[0-9]+" placeholder="Contoh: 628123456789"
                                   value="{{ $settings['store_phone'] ?? '' }}">
                            <small class="text-muted">Hanya angka. Contoh: <code>628123456789</code></small>
                        </div>

                         </div>
                </div>

                        {{-- 🔹 Rekening Owner --}}
                        <div class="card mb-4">
                            <div class="card-header"><h4>Rekening Pembayaran</h4></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama Bank</label>
                                    <input type="text" name="bank_name" class="form-control"
                                        placeholder="Contoh: Mandiri, BCA"
                                        value="{{ $settings['bank_name'] ?? '' }}">
                                </div>

                                <div class="form-group">
                                    <label>Nomor Rekening</label>
                                    <input type="text" name="bank_account_number" class="form-control"
                                        placeholder="Contoh: 0754343"
                                        value="{{ $settings['bank_account_number'] ?? '' }}">
                                </div>

                                <div class="form-group">
                                    <label>Nama Pemilik Rekening</label>
                                    <input type="text" name="bank_account_holder" class="form-control"
                                        placeholder="Contoh: Wahyu"
                                        value="{{ $settings['bank_account_holder'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                   

                {{-- 🔹 Media Sosial --}}
                <div class="card mb-4">
                    <div class="card-header"><h4>Media Sosial</h4></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Link Instagram</label>
                            <input type="url" name="store_instagram" class="form-control"
                                   placeholder="https://instagram.com/namaakun"
                                   value="{{ $settings['store_instagram'] ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Link TikTok</label>
                            <input type="url" name="store_tiktok" class="form-control"
                                   placeholder="https://tiktok.com/@namaakun"
                                   value="{{ $settings['store_tiktok'] ?? '' }}">
                        </div>
                    </div>
                </div>

                {{-- 🔹 Logo & Tema --}}
                <div class="card mb-4">
                    <div class="card-header"><h4>Logo & Tema</h4></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Logo Utama (Sidebar/Dashboard)</label><br>
                            @php $mainLogo = $settings['store_logo'] ?? null; @endphp
                            @if ($mainLogo)
                                <img src="{{ asset('storage/settings/' . $mainLogo) }}" alt="Logo Utama"
                                     class="img-thumbnail rounded shadow-sm mb-2" width="100"
                                     style="object-fit: cover; height: 100px;">
                            @endif
                            <input type="file" name="store_logo" class="form-control mt-2">
                        </div>

                        <div class="form-group">
                            <label>Logo Login & PDF/Print</label><br>
                            @php $altLogo = $settings['store_logo_alt'] ?? null; @endphp
                            @if ($altLogo)
                                <img src="{{ asset('storage/settings/' . $altLogo) }}" alt="Logo Alternatif"
                                     class="img-thumbnail rounded shadow-sm mb-2" width="100"
                                     style="object-fit: cover; height: 100px;">
                            @endif
                            <input type="file" name="store_logo_alt" class="form-control mt-2">
                        </div>

                        <div class="form-group">
                            <label>Warna Tema</label>
                            <select name="theme" class="form-control">
                                <option value="light" {{ ($settings['theme'] ?? 'light') === 'light' ? 'selected' : '' }}>Terang</option>
                                <option value="dark" {{ ($settings['theme'] ?? 'light') === 'dark' ? 'selected' : '' }}>Gelap</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" id="submit-settings" class="btn btn-primary">Simpan Pengaturan</button>

                {{-- <button type="submit" class="btn btn-primary swal-submit">Simpan</button> --}}

            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')

{{-- untuk alert dialog confirmasi --}}

<script>
document.addEventListener("DOMContentLoaded", function () {
    const settingForm = document.getElementById("setting-form");
    const submitBtn = document.getElementById("submit-settings");

    if (settingForm && submitBtn) {
        submitBtn.addEventListener("click", function (e) {
            e.preventDefault();

            Swal.fire({
                title: "Simpan Pengaturan?",
                text: "Perubahan akan disimpan dan langsung diterapkan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Simpan!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    settingForm.submit();
                }
            });
        });
    }
});
</script>

{{-- untuk alert bisa hilang dalam 3 detik --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.querySelector('.auto-dismiss-alert');

        if (alert) {
            // Fade out setelah 3 detik
            setTimeout(() => {
                alert.classList.remove('show');
                alert.style.opacity = '0';
            }, 3000);

            // Hapus dari DOM setelah 3.5 detik
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 3500);
        }
    });
</script>



@endpush



