@extends('layouts.app')

@section('title', 'Laporan Order')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Laporan Order</h1>
        </div>

        <div class="section-body">
            {{-- Filter Tanggal --}}
            <form method="GET" class="form-inline mb-3">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control mr-2">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control mr-2">
                <button class="btn btn-primary mr-2">Filter</button>
                <a href="{{ route('report.index') }}" class="btn btn-secondary">Reset</a>
            </form>

            {{-- Export --}}
            <div class="mb-3">
                <a href="{{ route('report.export.excel', request()->query()) }}" class="btn btn-success mr-2">
                    <i class="fas fa-file-excel"></i> Download Excel
                </a>
                <a href="{{ route('report.export.pdf', request()->query()) }}" class="btn btn-danger mr-2">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </a>
                <a href="{{ route('report.print', request()->query()) }}" target="_blank" class="btn btn-info mr-2">
                    <i class="fas fa-print"></i> Print
                </a>
            </div>

            {{-- Tabel Laporan --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Order</th>
                            <th>Produk</th>
                            <th>Gambar</th>
                            <th>Customer</th>
                            <th>Transaction Time</th>
                            <th>Total Item</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $i => $order)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>ORD-{{ $order->id }}</td>
                            <td>{{ $order->items->first()?->product->name ?? '-' }}</td>
                            <td>
                                @if($order->items->first()?->product?->images)
                                    <img src="{{ asset('storage/' . $order->items->first()->product->images[0]) }}" width="50">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $order->customer->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->transaction_time)->format('d-m-Y H:i') }}</td>
                            <td>{{ $order->total_item }}</td>
                            <td>Rp {{ number_format($order->total_price,0,',','.') }}</td>
                            <td>
                                @php
                                    // Ambil status berdasarkan slug yang ada di order
                                    $statusData = $statuses->firstWhere('slug', $order->status);
                                @endphp

                                <span class="badge text-white rounded-pill px-3" style="background-color:#0d6efd">
                                    {{-- Tampilkan name dari DB kalau ada, kalau tidak fallback ke slug --}}
                                    {{ $statusData->name ?? str_replace('_', ' ', $order->status) }}
                                </span>





                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </section>
</div>
@endsection
