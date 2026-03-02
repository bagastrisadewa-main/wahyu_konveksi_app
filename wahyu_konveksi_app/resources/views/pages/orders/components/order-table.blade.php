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
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                    <td>ORD-{{ $order->id }}</td>
                    <td>{{ $order->items->first()?->product->name ?? '-' }}</td>
                    <td>
                        @if($order->items->first()?->product?->images)
                            <img src="{{ asset('storage/' . $order->items->first()->product->images[0]) }}" width="50">
                        @else
                            -
                        @endif
                    </td>
                    
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->transaction_time)->format('d-m-Y H:i') }}</td>
                    <td>{{ $order->total_item }}</td>
                    <td>Rp {{ number_format($order->total_price,0,',','.') }}</td>
                    <td>
                        @php
                            $statusData = $statuses->firstWhere('slug', $order->status);
                            $statusName = $statusData->name ?? ucfirst($order->status);
                        @endphp
                        <span class="badge bg-primary text-white rounded-pill px-3">{{ $statusName }}</span>
                    </td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
{{ $orders->links() }}


    {{-- {{ $orders->withQueryString()->links() }} --}}
</div>
