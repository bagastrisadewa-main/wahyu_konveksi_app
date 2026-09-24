@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('main')
<div class="main-content">
<section class="section">
    <div class="section-header">
        <h1>Tambah Produk</h1>
    </div>

    <div class="section-body">
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card">
                <div class="card-body">

                    {{-- NAMA --}}
                    <div class="form-group">
                        <label>Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>

                    {{-- HARGA --}}
                    <div class="form-group">
                        <label>Harga Dasar <span class="text-danger">*</span></label>
                        <input type="text" name="price" class="form-control rupiah" value="{{ old('price') }}" required>
                        <small class="text-muted">Harga dasar sebelum tambahan opsi custom</small>
                    </div>

                    <input type="hidden" name="stock" value="0">

                    {{-- KATEGORI --}}
                    <div class="form-group">
                        <label>Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- GAMBAR --}}
                    <div class="form-group">
                        <label>Gambar Produk</label>
                        <input type="file" name="images[]" multiple class="form-control" id="imagesInput">
                        <div id="previewImages" class="d-flex mt-2"></div>
                    </div>

                    {{-- BEST SELLER --}}
                    <div class="form-group">
                        <label>Produk Unggulan</label>
                        <select name="is_best_seller" class="form-control">
                            <option value="0" {{ old('is_best_seller')==0?'selected':'' }}>Tidak</option>
                            <option value="1" {{ old('is_best_seller')==1?'selected':'' }}>Ya</option>
                        </select>
                    </div>

                    {{-- STATUS --}}
                    <div class="form-group">
                        <label>Status Produk</label>
                        <select name="is_active" class="form-control">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <hr>

                    {{-- OPSI CUSTOM --}}
                    <div class="form-group">
                        <label>Opsi Custom Produk</label>
                        <div id="optionsContainer">
                            {{-- ROW DEFAULT --}}
                            <div class="option-row row mb-2 align-items-center">
                                <input type="hidden" name="options[0][type]" value="checkbox">
                                <div class="col-md-4">
                                    <input type="text" name="options[0][name]" class="form-control" placeholder="Nama Opsi (contoh: Bordir)">
                                </div>
                                <div class="col-md-3">
                                    <select name="options[0][is_required]" class="form-control">
                                        <option value="0">Opsional</option>
                                        <option value="1">Wajib</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="options[0][values][0][label]" class="form-control" placeholder="Label value">
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <input type="text" name="options[0][values][0][extra_price]" class="form-control rupiah" placeholder="+ Harga">
                                    <button type="button" class="btn btn-sm btn-success ml-2 add-option">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <small class="text-muted">Harga tambahan akan dijumlahkan dengan harga dasar produk</small>

                        <hr>

                        {{-- AUTO SELECT ALL --}}
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="auto_select_all_custom" name="auto_select_all_custom" value="1" {{ old('auto_select_all_custom')?'checked':'' }}>
                                <label class="custom-control-label" for="auto_select_all_custom">
                                    Pilih semua opsi custom & tambahkan otomatis ke harga
                                </label>
                            </div>
                            <small class="text-muted d-block mt-1">
                                Jika dicentang, seluruh opsi custom akan otomatis aktif dan harga total dihitung dari harga dasar + semua tambahan.
                            </small>
                        </div>
                    </div>

                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('product.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Produk
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
</div>
@endsection

@push('scripts')


<script>
function showToast(messages, type = 'error') {
    const list = Array.isArray(messages) ? messages : [messages];
    if (window.iziToast) {
        iziToast[type]({
            title: type === 'error' ? 'Gagal' : 'Info',
            message: list.join('<br>'),
            position: 'topRight',
            timeout: 6000
        });
    } else if (window.toastr) {
        toastr[type](list.join('<br>'));
    } else {
        alert(list.join('\n'));
    }
}
</script>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        showToast(@json($errors->all()));
    });
</script>
@endif

<script>
document.addEventListener("DOMContentLoaded", function() {

    // FORMAT RUPIAH
    document.querySelectorAll('.rupiah').forEach(el => {
        el.addEventListener('input', function(){
            let value = this.value.replace(/\D/g,'');
            this.value = new Intl.NumberFormat('id-ID').format(value);
        });
    });

    // PREVIEW GAMBAR
    const imagesInput = document.getElementById('imagesInput');
    const previewImages = document.getElementById('previewImages');

    // VALIDASI OPSI CUSTOM SEBELUM SUBMIT
const optForm = document.getElementById('optionsContainer').closest('form');

optForm.addEventListener('submit', function(e){
    const emptyRows = [];
    let firstInvalid = null;

    document.querySelectorAll('#optionsContainer .option-row').forEach(row => {
        const isExisting = !!row.querySelector('input[name$="[id]"]');
        const nameEl  = row.querySelector('input[name$="[name]"]');
        const labelEl = row.querySelector('input[name$="[label]"]');
        const priceEl = row.querySelector('input[name$="[extra_price]"]');

       [nameEl, labelEl, priceEl].forEach(el => el && el.classList.remove('is-invalid'));

        if (isExisting) return;

        const filled = [nameEl, labelEl, priceEl].some(el => el && el.value.trim() !== '');
        if (!filled) { emptyRows.push(row); return; }

      [nameEl, labelEl, priceEl].forEach(el => {
            if (el && el.value.trim() === '') {
                el.classList.add('is-invalid');
                firstInvalid = firstInvalid || el;
            }
        });
    });

    if (firstInvalid) {
        e.preventDefault();
        showToast('Opsi custom belum lengkap: Nama Opsi, Label value, dan Harga wajib diisi.');
        firstInvalid.focus();
        return;
    }

    // baris kosong tidak ikut terkirim
    emptyRows.forEach(row => row.querySelectorAll('input, select').forEach(el => el.disabled = true));
});

    imagesInput.addEventListener('change', function(){
        previewImages.innerHTML = '';
        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '80px';
                img.style.marginRight = '5px';
                img.classList.add('rounded');
                previewImages.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

    // OPSI DINAMIS
    let optionIndex = 1;
    document.getElementById('optionsContainer').addEventListener('click', function(e){
        if(e.target.closest('.add-option')){
            const row = e.target.closest('.option-row');
            const newRow = row.cloneNode(true);
            newRow.querySelectorAll('input, select').forEach(el => {
                el.name = el.name.replace(/\d+/, optionIndex);
                if (el.type === 'hidden') return; // jangan reset hidden type="checkbox"
                if (el.tagName === 'SELECT') el.selectedIndex = 0;
                else el.value = '';
            });
            const btn = newRow.querySelector('button');
            btn.classList.remove('btn-success','add-option');
            btn.classList.add('btn-danger','remove-option');
            btn.innerHTML = '<i class="fas fa-trash"></i>';
            this.appendChild(newRow);
            optionIndex++;
        }
        if(e.target.closest('.remove-option')){
            e.target.closest('.option-row').remove();
        }
    });

    // AUTO PILIH SEMUA CUSTOM
    const autoCheck = document.getElementById('auto_select_all_custom');
    if(autoCheck){
        autoCheck.addEventListener('change', function(){
            document.querySelectorAll('.option-row').forEach(row => {
                const requiredSelect = row.querySelector('select[name*="[is_required]"]');
                if(requiredSelect) requiredSelect.value = this.checked ? 1 : 0;
                if(this.checked) row.setAttribute('data-auto', '1');
                else row.removeAttribute('data-auto');
            });
        });
    }
});
</script>
@endpush
