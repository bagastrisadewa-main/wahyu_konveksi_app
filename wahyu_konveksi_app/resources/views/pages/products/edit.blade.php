@extends('layouts.app')

@section('title', 'Edit Produk')

@section('main')
<div class="main-content">
<section class="section">
    <div class="section-header">
        <h1>Edit Produk</h1>
        <div class="section-header-button">
            <a href="{{ route('product.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="section-body">
        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-body">

                    {{-- NAMA --}}
                    <div class="form-group">
                        <label>Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                    </div>

                    {{-- HARGA --}}
                    <div class="form-group">
                        <label>Harga Dasar <span class="text-danger">*</span></label>
                        <input type="text" name="price" class="form-control rupiah" value="{{ old('price', $product->price) }}" required>
                        <small class="text-muted">Harga dasar sebelum tambahan opsi custom</small>
                    </div>

                    <input type="hidden" name="stock" value="0">

                    {{-- KATEGORI --}}
                    <div class="form-group">
                        <label>Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id)==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- GAMBAR --}}
                    <div class="form-group">
                        <label>Gambar Produk</label>
                        <input type="file" name="images[]" multiple class="form-control" id="imagesInput">
                        <div id="previewImages" class="d-flex mt-2">
                            @if($product->images)
                                @foreach($product->images as $img)
                                    <img src="{{ asset('storage/'.$img) }}" class="rounded mr-2" style="width:80px;">
                                @endforeach
                            @endif
                        </div>
                    </div>

                    {{-- BEST SELLER --}}
                    <div class="form-group">
                        <label>Produk Unggulan</label>
                        <select name="is_best_seller" class="form-control">
                            <option value="0" {{ old('is_best_seller', $product->is_best_seller)==0?'selected':'' }}>Tidak</option>
                            <option value="1" {{ old('is_best_seller', $product->is_best_seller)==1?'selected':'' }}>Ya</option>
                        </select>
                    </div>

                    {{-- STATUS --}}
                    <div class="form-group">
                        <label>Status Produk</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active', $product->is_active)==1?'selected':'' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $product->is_active)==0?'selected':'' }}>Nonaktif</option>
                        </select>
                    </div>

                    <hr>

                    {{-- OPSI PRODUK --}}
                    <div class="form-group">
                        <label>Opsi Custom Produk</label>
                        <div id="optionsContainer">
                            @if($product->options && $product->options->count() > 0)
                                @foreach($product->options as $oIndex => $option)
                                    <div class="option-row row mb-2 align-items-center">
                                        <input type="hidden" name="options[{{ $oIndex }}][id]" value="{{ $option->id }}">
                                        <div class="col-md-3">
                                            <input type="text" name="options[{{ $oIndex }}][name]" class="form-control" value="{{ $option->name }}" placeholder="Nama Opsi">
                                        </div>
                                        <div class="col-md-2">
                                            <select name="options[{{ $oIndex }}][type]" class="form-control">
                                                <option value="checkbox" {{ $option->type=='checkbox'?'selected':'' }}>Checkbox</option>
                                                <option value="select" {{ $option->type=='select'?'selected':'' }}>Pilihan</option>
                                                <option value="number" {{ $option->type=='number'?'selected':'' }}>Jumlah</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="options[{{ $oIndex }}][is_required]" class="form-control">
                                                <option value="0" {{ $option->is_required==0?'selected':'' }}>Opsional</option>
                                                <option value="1" {{ $option->is_required==1?'selected':'' }}>Wajib</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 d-flex flex-column">
                                            @foreach($option->values as $vIndex => $val)
                                                <div class="d-flex mb-1 align-items-center value-row">
                                                    <input type="text" class="form-control mr-2" value="{{ $val->label }}" readonly>
                                                    <input type="text" class="form-control rupiah mr-2" value="{{ number_format($val->extra_price,0,'','.') }}" readonly>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-2 d-flex align-items-center">
                                            <button type="button" class="btn btn-sm btn-danger remove-option">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <button type="button" class="btn btn-sm btn-success mt-2" id="addNewOption">
                            <i class="fas fa-plus"></i> Tambah Opsi
                        </button>

                        <div class="form-group mt-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="auto_select_all_custom" name="auto_select_all_custom" value="1" {{ $product->auto_select_all_custom?'checked':'' }}>
                                <label class="custom-control-label" for="auto_select_all_custom">
                                    Pilih semua opsi custom & tambahkan otomatis ke harga
                                </label>
                            </div>
                        </div>

                        <small class="text-muted d-block mt-1">
                            Jika dicentang, seluruh opsi custom akan otomatis aktif dan harga total dihitung dari harga dasar + semua tambahan.
                        </small>
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
document.addEventListener("DOMContentLoaded", function(){



    // FORMAT RUPIAH
document.addEventListener('input', function(e){
    if (e.target.matches('.rupiah')) {
        const v = e.target.value.replace(/\D/g,'');
        e.target.value = v ? new Intl.NumberFormat('id-ID').format(v) : '';
    }
});

    // PREVIEW GAMBAR
    const imagesInput = document.getElementById('imagesInput');
    const previewImages = document.getElementById('previewImages');
    imagesInput.addEventListener('change', function(){
        previewImages.innerHTML = '';
        Array.from(this.files).forEach(file=>{
            const reader = new FileReader();
            reader.onload = e=>{
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

    // TAMBAH & HAPUS OPSI
    const container = document.getElementById('optionsContainer');
    let optionIndex = {{ $product->options->count() ?? 0 }};

    // Hidden container untuk opsi yang dihapus
    const form = container.closest('form');
    const deletedOptionsInput = document.createElement('div');
    deletedOptionsInput.id = 'deletedOptionsContainer';
    form.appendChild(deletedOptionsInput);

        // VALIDASI OPSI CUSTOM SEBELUM SUBMIT  ← pindah ke sini
    form.addEventListener('submit', function(e){
        const emptyRows = [];
        let firstInvalid = null;

        container.querySelectorAll('.option-row').forEach(row => {
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

        emptyRows.forEach(row => row.querySelectorAll('input, select').forEach(el => el.disabled = true));
    });

    document.getElementById('addNewOption').addEventListener('click', function(){
        const div = document.createElement('div');
        div.classList.add('option-row','row','mb-2','align-items-center');
        div.innerHTML = `
            <div class="col-md-3">
                <input type="text" name="options[${optionIndex}][name]" class="form-control" placeholder="Nama Opsi">
            </div>
            <div class="col-md-2">
                <select name="options[${optionIndex}][type]" class="form-control">
                    <option value="checkbox">Checkbox</option>
                    <option value="select">Pilihan</option>
                    <option value="number">Jumlah</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="options[${optionIndex}][is_required]" class="form-control">
                    <option value="0">Opsional</option>
                    <option value="1">Wajib</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-center">
                <input type="text" name="options[${optionIndex}][values][0][label]" class="form-control mr-2" placeholder="Label value">
                <input type="text" name="options[${optionIndex}][values][0][extra_price]" class="form-control rupiah" placeholder="+ Harga">
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-danger remove-option">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(div);
        optionIndex++;


    });

    // HAPUS OPSI
    container.addEventListener('click', function(e){
        if(e.target.closest('.remove-option')){
            const optionRow = e.target.closest('.option-row');
            const optionIdInput = optionRow.querySelector('input[name*="[id]"]');
            if(optionIdInput && optionIdInput.value){
                // Jika opsi lama, buat hidden input untuk backend
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'deleted_options[]';
                hidden.value = optionIdInput.value;
                deletedOptionsInput.appendChild(hidden);
            }
            optionRow.remove();
        }
    });

    // AUTO PILIH SEMUA CUSTOM
    const autoCheck = document.getElementById('auto_select_all_custom');
    if(autoCheck){
        autoCheck.addEventListener('change', function(){
            document.querySelectorAll('.option-row').forEach(row=>{
                const requiredSelect = row.querySelector('select[name*="[is_required]"]');
                if(requiredSelect) requiredSelect.value = this.checked ? 1 : 0;
            });
        });
    }

});
</script>
@endpush
