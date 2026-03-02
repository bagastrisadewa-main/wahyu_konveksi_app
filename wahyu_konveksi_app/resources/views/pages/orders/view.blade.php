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
            <div class="card mb-3">
                <div class="card-body">
                    <p><strong>Kode Order:</strong> ORD-{{ $order->id }}</p>
                    <p><strong>Customer:</strong> {{ $order->customer->name }}</p>
                    <p><strong>Alamat:</strong> {{ $order->customer->address ?? '-' }}</p>
                    <p><strong>No WA:</strong> {{ $order->customer->phone }}</p>
                    <p><strong>Total Item:</strong> {{ $order->total_item }}</p>
                    <p><strong>Total Harga:</strong> Rp {{ number_format($order->total_price,0,',','.') }}</p>
                    <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method }}</p>
                    <p>
                        <strong>Status:</strong>
                        <select id="order-status-select" class="form-control d-inline-block w-auto me-2">
                            @foreach($statuses as $st)
                                <option value="{{ $st->slug }}" {{ $order->status == $st->slug ? 'selected' : '' }}>
                                    {{ $st->name }}
                                </option>
                            @endforeach
                        </select>
                        <span id="status-badge" class="badge bg-primary text-white rounded-pill px-3">
                            {{ $statuses->firstWhere('slug', $order->status)?->name ?? '-' }}
                        </span>
                    </p>
                    <p><strong>Waktu Transaksi:</strong> {{ \Carbon\Carbon::parse($order->transaction_time)->format('d-m-Y H:i') }}</p>
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
