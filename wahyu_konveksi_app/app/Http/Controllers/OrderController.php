<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\ProductionProcess;
use Carbon\Carbon;

class OrderController extends Controller
{
    // =========================
    // Daftar order
    // =========================
public function index(Request $request)
{
    $perPage = $request->per_page ?? 10;

    $orders = Order::with(['customer','items.product'])
        ->when($request->search, function($q) use ($request) {
            $keyword = $request->search;

            $q->where(function($q2) use ($keyword) {
                $q2->where('order_code','like',"%{$keyword}%") // search by order_code
                   ->orWhere('id','like',"%{$keyword}%")       // search by order id
                   ->orWhereHas('customer', fn($q3) => 
                        $q3->where('name','like',"%{$keyword}%")
                   )
                   ->orWhereHas('items.product', fn($q4) =>
                        $q4->where('name','like',"%{$keyword}%") // search by product name
                   );
            });
        })
        ->when($request->status, fn($q) => $q->where('status', $request->status))
        ->orderBy('transaction_time','desc')
        ->paginate($perPage)
        ->withQueryString();

    $statuses = OrderStatus::where('is_active',1)->orderBy('order')->get();

    if ($request->ajax()) {
        return response()->json([
            'html' => view('pages.orders.components.order-table', compact('orders','statuses'))->render()
        ]);
    }

    return view('pages.orders.index', compact('orders','statuses'));
}







    // =========================
    // Detail order
    // =========================
    public function show($id)
    {
        $order = Order::with([
            'customer',
            'items.product',
            'items.options',
            'items.processes' // ⬅️ STOP DI SINI
        ])->findOrFail($id);

        $statuses = OrderStatus::where('is_active', 1)
            ->orderBy('order')
            ->get();

        $processes = ProductionProcess::orderBy('order')->get();

        return view('pages.orders.view', compact('order','statuses','processes'));
    }


    // =========================
    // Update status order + proses item
    // =========================

        public function saveOrderUpdates(Request $request, $orderId)
        {
            $order = Order::with('items.processes')->findOrFail($orderId);

            // Ambil data master status
            $masterStatuses = \App\Models\OrderStatus::pluck('slug','slug'); // ['draft'=>'draft','selesai'=>'selesai',...]

            // Update status order
            $orderStatus = $request->status;
            $order->status = $orderStatus;
            $order->save();

            // Status untuk proses item
            $itemProcessStatus = ($orderStatus === 'selesai') ? 'completed' : 'processing';

            // Update setiap item
            if ($request->filled('items')) {
                foreach ($request->items as $itemId => $processName) {
                    $item = \App\Models\OrderItem::find($itemId);
                    if (!$item) continue;

                    $last = $item->processes()->latest('id')->first();

                    // Buat record baru kalau belum ada atau proses berbeda
                    if (!$last || $last->process !== $processName) {

                        // Tutup proses sebelumnya dulu sebelum bikin yang baru
                        if ($last && $last->status !== 'completed') {
                            $last->update([
                                'status'       => 'completed',
                                'completed_at' => now()
                            ]);
                        }

                        $item->processes()->create([
                            'process'      => $processName,       // nama proses
                            'status'       => $itemProcessStatus, // ambil dari order status
                            'started_at'   => now(),
                            'completed_at' => $itemProcessStatus === 'completed' ? now() : null
                        ]);
                    } else {
                        // Kalau sama tapi status order sudah selesai, update completed_at
                        if ($itemProcessStatus === 'completed' && $last->status !== 'completed') {
                            $last->update([
                                'status'       => 'completed',
                                'completed_at' => now()
                            ]);
                        }
                    }
                }
            }

            return response()->json(['success' => true]);
        }


    //     public function saveOrderUpdates(Request $request, $orderId)
    // {
    //     $order = Order::with('items.processes')->findOrFail($orderId);

    //     // Update status order
    //     $order->status = $request->status;
    //     $order->save();

    //     if ($request->filled('items')) {
    //         foreach ($request->items as $itemId => $processSlug) {
    //             $item = OrderItem::with('processes')->find($itemId);
    //             if ($item) {
    //                 $lastProcess = $item->processes->last();

    //                 // Buat record baru jika belum ada atau proses berbeda
    //                 if (!$lastProcess || $lastProcess->process != $processSlug) {
    //                     $item->processes()->create([
    //                         'process'      => $processSlug,  // simpan slug/nama proses
    //                         'status'       => 'processing',
    //                         'started_at'   => now(),
    //                         'completed_at' => null
    //                     ]);
    //                 }
    //             }
    //         }
    //     }

    //     // Kalau request ajax
    //     if ($request->ajax() || $request->wantsJson()) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Perubahan order dan proses produksi berhasil disimpan.'
    //         ]);
    //     }

    //     return redirect()->back()->with('success', 'Perubahan order dan proses produksi berhasil disimpan.');
    // }


    // =========================
    // Kirim WA ke customer
    // =========================
       public function sendWA($orderId)
{
    // ambil order lengkap
    $order = Order::with([
        'customer',
        'items.product',
        'items.options',
        'items.processes',
        'statusData'
    ])->findOrFail($orderId);

    $customer = $order->customer;

    // ambil master proses untuk mapping ID → nama
    $processMaster = ProductionProcess::pluck('name', 'id');

    // mulai bikin pesan WA
    $message  = "Halo {$customer->name}, Berikut detail order Anda:%0A";
    $message .= "Kode Order: ORD-{$order->id}%0A";
    $message .= "Tanggal Order: " . Carbon::parse($order->transaction_time)->format('d-m-Y H:i') . "%0A";
    $message .= "Total Item: {$order->total_item}%0A";
    $message .= "Total Harga: Rp " . number_format($order->total_price, 0, ',', '.') . "%0A";
    $message .= "=================%0A";

    foreach ($order->items as $item) {

        $subtotal = $item->subtotal + $item->options->sum('extra_price');

        $message .= "{$item->product->name} - Qty: {$item->qty} - Rp "
            . number_format($subtotal, 0, ',', '.') . "%0A";

        // ambil proses terakhir item
        $lastProcess = $item->processes()->latest('id')->first();

        $processName = 'Belum diproses';

        if ($lastProcess) {
            // jika numeric → data lama → mapping ke master
            if (is_numeric($lastProcess->process)) {
                $processName = $processMaster[$lastProcess->process] ?? 'Belum diproses';
            } else {
                // jika sudah text → data baru
                $processName = $lastProcess->process;
            }
        }

        $message .= "Status proses produksi sampai tahap : {$processName}%0A";
    }

    $message .= "=================%0A";
    $message .= "Status Order: " . ($order->statusData->name ?? ucfirst($order->status)) . "%0A";

    // format nomor WA internasional
    $phone = preg_replace('/^0/', '62', $customer->phone);

    // redirect ke WA
    return redirect("https://wa.me/{$phone}?text={$message}");
}

}
