@extends('layouts.app')

@section('title', 'Detail Order')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Order</h1>
                     
            {{-- Breadcrumb --}}
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('orders.index') }}">Order</a></div>
                <div class="breadcrumb-item active">Detail Order</div>
            </div>
        </div>

          

        <div class="section-body">
            @include('layouts.alert')

         
            {{-- Informasi Order --}}
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Order</h5>
                    <span id="status-badge" class="badge bg-primary text-white rounded-pill px-3 py-2">
                        {{ $statuses->firstWhere('slug', $order->status)?->name ?? '-' }}
                    </span>
                </div>

                <div class="card-body">
                    <div class="row gy-4">

                        <div class="col-md-3 col-sm-6">
                            <div class="text-muted small mb-1">Kode Order</div>
                            <div class="fw-semibold">ORD-{{ $order->id }}</div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="text-muted small mb-1">Customer</div>
                            <div class="fw-semibold">{{ $order->customer->name }}</div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="text-muted small mb-1">No. WhatsApp</div>
                            <div class="fw-semibold">{{ $order->customer->phone ?? '-' }}</div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="text-muted small mb-1">Waktu Transaksi</div>
                            <div class="fw-semibold">
                                {{ \Carbon\Carbon::parse($order->transaction_time)->format('d M Y, H:i') }}
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="text-muted small mb-1">Alamat</div>
                            <div class="fw-semibold">{{ $order->customer->address ?? '-' }}</div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="text-muted small mb-1">Total Item</div>
                            <div class="fw-semibold">{{ $order->total_item }}</div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="text-muted small mb-1">Total Harga</div>
                            <div class="fw-semibold text-success">
                                Rp {{ number_format($order->total_price,0,',','.') }}
                            </div>
                        </div>

                    </div>

                    <hr class="my-4">

                    {{-- Info Pembayaran --}}

                <div class="row">
                    <div class="col-md-8">
                        <div class="text-muted small mb-2">
                            <i class="fas fa-money-check-alt me-1"></i> Metode Pembayaran
                        </div>

                        @php
                            $payment = $order->payment_method ?? '-';
                            preg_match('/Rek\.(.*?)\s+([\w\d]+)\s+AN\.(.*)/i', $payment, $match);
                        @endphp

                        @if(!empty($match))
                            <div class="mb-1">
                                <span class="text-muted small">Bank:</span>
                                <span class="fw-semibold">{{ trim($match[1]) }}</span>
                            </div>
                            <div class="mb-1">
                                <span class="text-muted small">No. Rekening:</span>
                                <span class="fw-semibold">{{ trim($match[2]) }}</span>
                            </div>
                            <div class="mb-1">
                                <span class="text-muted small">Atas Nama:</span>
                                <span class="fw-semibold">{{ trim($match[3]) }}</span>
                            </div>
                        @else
                            <div class="fw-semibold">{{ $payment }}</div>
                        @endif
                    </div>
                </div>
                    <hr class="my-4">

                    {{-- Status Order (editable) --}}
                    <div class="row align-items-center">
                        <div class="col-md-4 col-sm-6">
                            <label class="text-muted small mb-1 d-block">Ubah Status Order</label>
                            <select id="order-status-select" class="form-control">
                                @foreach($statuses as $st)
                                    <option value="{{ $st->slug }}" {{ $order->status == $st->slug ? 'selected' : '' }}>
                                        {{ $st->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Tabel Item --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Produk dalam Order</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Produk</th>
                                    <th>Gambar</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Catatan</th>
                                    <th>Proses</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr id="item-row-{{ $item->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>
                                        @if(!empty($item->product->images) && is_array($item->product->images))
                                            <img src="{{ asset('storage/' . $item->product->images[0]) }}" width="50">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($item->price,0,',','.') }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>Rp {{ number_format($item->subtotal + $item->options->sum('extra_price'),0,',','.') }}</td>
                                    <td>{{ $item->note ?? '-' }}</td>
                                    <td>
                                    @php
                                        $lastProcess = $item->processes->last();
                                    @endphp

                                        @php
                                        $lastProcess = $item->processes->last();

                                        $processLabel = 'Belum diproses';
                                        $selectedProcess = null; // <-- untuk dropdown

                                        if ($lastProcess) {
                                            if (is_numeric($lastProcess->process)) {
                                                // Ambil nama dari master proses
                                                $processName = optional($processes->firstWhere('id', $lastProcess->process))->name;
                                                $processLabel = $processName ?? 'Belum diproses';
                                                $selectedProcess = $processName ?? null;
                                            } else {
                                                // Sudah berupa text
                                                $processLabel = $lastProcess->process;
                                                $selectedProcess = $lastProcess->process;
                                            }
                                        }
                                        @endphp

                                        <span id="item-process-badge-{{ $item->id }}" class="badge bg-success text-white rounded-pill">
                                            {{ $processLabel }}
                                        </span>

                                        <select class="form-control d-inline-block w-auto mt-1 item-process-select" name="items[{{ $item->id }}]">
                                            @foreach($processes as $p)
                                                <option value="{{ $p->name }}" {{ $selectedProcess === $p->name ? 'selected' : '' }}>
                                                    {{ $p->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <div class="mb-3 d-flex justify-content-between align-items-center">
            {{-- Tombol Back --}}
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">← Kembali</a>

            {{-- Tombol Simpan & WA --}}
            <div class="d-flex align-items-center" style="gap: 12px;">
                <button class="btn btn-primary swal-save">
                    Simpan Perubahan
                </button>

                <button class="btn btn-success" onclick="sendWA({{ $order->id }})">
                    Kirim WA
                </button>
            </div>
        </div>


        {{-- </div> --}}
    </section>
</div>
@endsection



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function sendWA(orderId){
    const url = "{{ route('order.sendWA', ':id') }}".replace(':id', orderId);
    window.open(url, '_blank');
}

document.addEventListener('DOMContentLoaded', function () {

    $(document).on('click', '.swal-save', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Simpan Perubahan?',
            text: 'Status order dan proses produksi akan diperbarui.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (!result.isConfirmed) return;

            Swal.fire({
                title: 'Menyimpan...',
                text: 'Mohon tunggu',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            const formData = new FormData();

            // status order
            formData.append(
                'status',
                document.getElementById('order-status-select').value
            );

            // proses item
            document.querySelectorAll('.item-process-select').forEach(select => {
                const itemId = select.name.match(/\d+/)[0];
                formData.append(`items[${itemId}]`, select.value);
            });

            fetch("{{ url('orders') }}/{{ $order->id }}/save", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Server error');
                }
                return res.json();
            })
            .then(() => {

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Perubahan berhasil disimpan',
                    timer: 1500,
                    showConfirmButton: false
                });

                // update badge status order
                const st = document.getElementById('order-status-select');
                document.getElementById('status-badge').textContent =
                    st.options[st.selectedIndex].text;

                // update badge proses item
                document.querySelectorAll('.item-process-select').forEach(select => {
                    const id = select.name.match(/\d+/)[0];
                    const badge = document.getElementById('item-process-badge-' + id);
                    badge.textContent = select.options[select.selectedIndex].text;
                    badge.classList.remove('bg-secondary', 'bg-success');
                    badge.classList.add('bg-primary');
                });

            })
            .catch((error) => {

                console.error(error);

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menyimpan',
                    text: 'Terjadi kesalahan. Silakan coba lagi.',
                    confirmButtonColor: '#d33'
                });

            });
        });
    });

});
</script>
@endpush
