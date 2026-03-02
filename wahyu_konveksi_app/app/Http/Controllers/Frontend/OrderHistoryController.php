<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem; // 🔥 WAJIB ADA
use App\Models\CartItem;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $customerId = Auth::guard('customer')->id();

        $orders = Order::with(['statusData'])
            ->where('customer_id', $customerId)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('frontend.orders.history', compact('orders'));
    }

    public function show(Order $order)
    {
        $customerId = Auth::guard('customer')->id();

        if ($order->customer_id != $customerId) {
            abort(403);
        }

        $order->load([
            'items.product',
            'statusData'
        ]);

        return view('frontend.orders.show', compact('order'));
    }



        public function reorder($orderId)
        {
            $customer = auth()->guard('customer')->user();

            if (!$customer) {
                return redirect()->route('frontend.login');
            }

            $order = Order::with(['items.options', 'items.product'])
                ->where('id', $orderId)
                ->where('customer_id', $customer->id)
                ->firstOrFail();

            foreach ($order->items as $item) {

                $extraPrice = $item->options->sum('extra_price');
                $subtotal   = ($item->price + $extraPrice) * $item->qty;

                OrderItem::create([
                    'order_id'    => null,
                    'customer_id' => $customer->id,
                    'product_id'  => $item->product_id,
                    'price'       => $item->price,
                    'qty'         => $item->qty,
                    'note'        => $item->note,
                    'subtotal'    => $subtotal,
                ]);
            }

            return redirect()->route('frontend.cart.index')
                ->with('success', 'Produk berhasil dimasukkan kembali ke keranjang.');
        }
}