<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;
use Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    // ================= Tampilkan halaman keranjang =================
  public function index()
{
    $customer = Auth::guard('customer')->user();

    $cartItems = $customer
        ? OrderItem::with(['product', 'options'])
            ->where('customer_id', $customer->id)
            ->whereNull('order_id')
            ->get()
        : collect();

    $total = $cartItems->sum(function($item) {
        return ($item->price + $item->options->sum('extra_price')) * $item->qty;
    });

    // Tampilkan view blade, jangan JSON
    return view('frontend.pages.cart.index', compact('cartItems', 'total', 'customer'));
}


    // ================= Tambah item ke cart =================
    public function add(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) return response()->json(['error' => 'Harus login'], 401);

        $product = Product::findOrFail($request->product_id);
        $qty = intval($request->qty ?? 1);
        $note = $request->note ?? null;

        $subtotal = $product->price * $qty;

        $item = OrderItem::create([
            'order_id'    => null,
            'customer_id' => $customer->id,
            'product_id'  => $product->id,
            'price'       => $product->price,
            'qty'         => $qty,
            'note'        => $note,
            'subtotal'    => $subtotal,
        ]);

        if ($request->options && is_array($request->options)) {
            foreach ($request->options as $opt) {
                $item->options()->create([
                    'option_name' => $opt['name'],
                    'extra_price' => $opt['extra_price'] ?? 0
                ]);
            }
            $item->calculateSubtotal();
        }

        $cartCount = $customer->cartItems()->count();

        return response()->json([
            'success' => true,
            'cartCount' => $cartCount
        ]);
    }


 // ================= Update item (SYNC ONLY) =================
    public function ajaxUpdate(Request $request, $itemId)
    {
        $item = OrderItem::with('options')->findOrFail($itemId);
        $qty = intval($request->qty ?? 0);

        if ($qty <= 0) {
            $item->delete();
        } else {
            $item->update([
                'qty' => $qty,
                'subtotal' => ($item->price + $item->options->sum('extra_price')) * $qty
            ]);
        }

        return response()->json(['success' => true]);
    }


   // ================= Checkout + Kirim WA =================

        public function checkoutAndWA()
        {
            $customer = Auth::guard('customer')->user();
            if (!$customer) {
                return redirect()->route('frontend.login');
            }

            $cartItems = OrderItem::with(['options','product'])
                ->where('customer_id', $customer->id)
                ->whereNull('order_id')
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('frontend.cart.index')
                    ->with('error', 'Keranjang belanja kosong!');
            }

            // ================= BUAT ORDER =================
            $orderCode = 'OC-' . strtoupper(Str::random(6));

            $totalPrice = $cartItems->sum(fn ($i) =>
                ($i->price + $i->options->sum('extra_price')) * $i->qty
            );

            $subtotal = $cartItems->sum(fn ($i) =>
                $i->price * $i->qty
            );

            $totalItem = $cartItems->sum('qty');

            $order = Order::create([
                'customer_id'      => $customer->id,
                'order_code'       => $orderCode,
                'total_price'      => $totalPrice,
                'subtotal'         => $subtotal,
                'total_item'       => $totalItem,
                'status'           => 'menunggu_konfirmasi',
                'transaction_time' => now(),
                'payment_method'   => 'Transfer Rek.Mandiri 0754343 AN.Wahyu',
            ]);

            // ================= SIMPAN ORDER_ID KE ITEM =================
            foreach ($cartItems as $item) {
                $item->update([
                    'order_id' => $order->id
                ]);
            }

            // ================= FORMAT PESAN WHATSAPP (BENAR) =================
            $itemsText = $cartItems->map(function ($i) {
                $opsi = $i->options->count()
                    ? ' (' . $i->options->pluck('option_name')->join(', ') . ')'
                    : '';

                $hargaItem = ($i->price + $i->options->sum('extra_price')) * $i->qty;

                return "- {$i->product->name} x{$i->qty}{$opsi} = Rp " . number_format($hargaItem);
            })->implode("\n");

            $waMessage =
        "Halo Admin WHS Konveksindo

        Saya ingin memesan:
        {$itemsText}

        Total: Rp " . number_format($totalPrice) . "

        Nama: {$customer->name}
        WA: {$customer->phone}
        Alamat: {$customer->address}

        Nomor Order: {$orderCode}";

            // ⬇️ INI KUNCI UTAMANYA
            $waUrl = "https://api.whatsapp.com/send?phone=6287738728252&text="
                . rawurlencode($waMessage);

            // ================= (OPSIONAL) KOSONGKAN CART =================
            OrderItem::where('customer_id', $customer->id)
                ->where('order_id', $order->id)
                ->update(['customer_id' => null]);

            // ================= KEMBALI KE CART + SESSION WA =================
            return redirect()->route('frontend.cart.index')
                ->with('success', 'Order berhasil dicatat! Nomor Order: ' . $orderCode)
                ->with('wa_url', $waUrl);
        }


// public function checkoutAndWA(Request $request)
// {
//     $customer = Auth::guard('customer')->user();
//     if (!$customer) {
//         return redirect()->route('frontend.login');
//     }

//     $cartItems = OrderItem::with('options', 'product')
//                     ->where('customer_id', $customer->id)
//                     ->whereNull('order_id')
//                     ->get();

//     if ($cartItems->isEmpty()) {
//         return redirect()->back()->with('error', 'Keranjang belanja kosong!');
//     }

//     // Buat nomor order unik
//     // $orderNumber = 'ORD-' . strtoupper(Str::random(6));
//     $orderCode   = 'OC-' . strtoupper(Str::random(6)); // <-- field wajib di DB

//     // Buat order baru
//         $order = Order::create([
//             'customer_id'    => $customer->id,
//             'order_code'     => $orderCode,
//             'total_price'    => $cartItems->sum(fn($i) => ($i->price + $i->options->sum('extra_price')) * $i->qty), // total + opsi
//             'total_item'     => $cartItems->sum(fn($i) => $i->qty), // jumlah semua item
//             'subtotal'       => $cartItems->sum(fn($i) => $i->price * $i->qty), // harga dasar tanpa opsi
//             'status'         => 'Menunggu Konfirmasi',
//             'transaction_time' => now(),
//             'payment_method'  => 'Transfer Rek.Mandiri 0754343 AN.Wahyu', // default sementara
//             // 'kasir_id'    => 1, // atau 0 / sesuai default
//         ]);

//     // Update order_id di masing-masing order item
//     foreach ($cartItems as $item) {
//         $item->order_id = $order->id;
//         $item->save();
//     }

//     // Siapkan teks WA
//     $itemsText = $cartItems->map(fn($i) => 
//         $i->product->name 
//         . ' x' . $i->qty
//         . ($i->options->count() ? ' (' . $i->options->pluck('option_name')->join(', ') . ')' : '')
//     )->join('%0A');

//         $waText = "Halo Admin WHS Konveksindo,%0ASaya ingin memesan:%0A" 
//                 . $itemsText 
//                 . "%0ATotal: Rp" . number_format($order->total_price)
//                 . "%0ANama: " . $customer->name
//                 . "%0AWA: " . $customer->phone
//                 . "%0AAlamat: " . $customer->address
//                 . "%0ANomor Order: " . $orderCode;

// session()->flash('success', 'Order berhasil dicatat! Nomor Order: ' . $orderCode);

//     // Kosongkan keranjang (hapus item yang order_id null)
//     OrderItem::where('customer_id', $customer->id)
//         ->whereNull('order_id')
//         ->delete();

//     // Simpan flash message untuk toast dan WA URL
//     session()->flash('success', 'Order berhasil dicatat! Nomor Order: ' . $orderCode);
//     session()->flash('wa_url', "https://api.whatsapp.com/send?phone=6287738728252&text=$waText");

//     // Redirect kembali ke halaman cart untuk menampilkan toast
//     return redirect()->route('frontend.cart.index');
// }

}
