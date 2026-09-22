@extends('frontend.layouts.app')

@section('title', 'History Order')

@section('content')
@include('frontend.auth.components.header-spacer')
<div class="container py-5">
    <h3 class="mb-4">📦 History Order</h3>

    @if($orders->count() == 0)
        <div class="alert alert-info">
            Belum ada order.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_code }}</td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>Rp {{ number_format($order->total_price) }}</td>
                            <td>
                                @forelse($order->items as $item)
                                    <div class="small mb-1">
                                        <span class="text-muted">{{ $item->product->name ?? 'Item' }}:</span>
                                        <span class="badge bg-{{ $item->process_color }}">
                                            {{ $item->process_label }}
                                        </span>
                                    </div>
                                @empty
                                    <span class="badge bg-secondary">Belum diproses</span>
                                @endforelse
                            </td>
                        <td>
                            <a href="{{ route('frontend.orders.history.show', $order->id) }}"
                               class="btn btn-sm btn-dark">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $orders->links() }}
    @endif
</div>
@endsection