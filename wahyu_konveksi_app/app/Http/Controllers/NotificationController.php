<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Ambil notifikasi order baru yang belum dibaca
     */
  public function orders()
{
    // Ambil 5 order terbaru yang belum dibaca
      $orders = Order::where('status', 'menunggu_konfirmasi')
            ->where('is_read', 0)
            ->latest()
            ->limit(5)
            ->get();

    // Debug log ke laravel log
    \Log::info('DEBUG: orders notifikasi', $orders->toArray());

    $count = $orders->count();

    $data = $orders->map(function($order) {
        return [
            'id' => $order->id,
            'order_code' => 'ORD-' . $order->id,
            'customer' => $order->customer->name ?? '-',
            'status' => ucfirst($order->status),
            'url' => route('orders.show', $order->id),
        ];
    });

    return response()->json([
        'count' => $count,
        'orders' => $data
    ]);
}

    /**
     * Tandai order sebagai sudah dibaca
     */
    public function markAsRead(Request $request)
    {
        $orderIds = $request->ids ?? [];

        if (!empty($orderIds)) {
            Order::whereIn('id', $orderIds)->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }
}
