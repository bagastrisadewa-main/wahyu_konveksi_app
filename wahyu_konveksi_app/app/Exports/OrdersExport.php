<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderStatus;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $start = $this->request->start_date;
        $end   = $this->request->end_date;

        // Ambil semua status sekali saja
        $statuses = OrderStatus::all()->keyBy('slug');

        $orders = Order::with(['items.product', 'customer'])
            ->when($start, fn ($q) =>
                $q->whereDate('transaction_time', '>=', $start))
            ->when($end, fn ($q) =>
                $q->whereDate('transaction_time', '<=', $end))
            ->latest()
            ->get();

        return $orders->values()->map(function ($order, $i) use ($statuses) {

            $statusName = $statuses[$order->status]->name
                ?? ucfirst(str_replace('_', ' ', $order->status));

            return [
                'No'           => $i + 1,
                'Kode Order'   => 'ORD-' . $order->id,
                'Produk'       => $order->items
                                        ->pluck('product.name')
                                        ->filter()
                                        ->implode(', '),
                'Customer'     => $order->customer->name ?? '-',
                'Total Item'   => $order->total_item,
                'Total'        => $order->total_price,
                'Status'       => $statusName,
                'Tanggal'      => Carbon::parse($order->transaction_time)
                                        ->translatedFormat('d M Y H:i'),
            ];
        });
    }
}
