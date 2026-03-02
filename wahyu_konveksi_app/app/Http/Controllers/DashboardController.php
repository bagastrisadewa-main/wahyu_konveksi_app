<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItemProcessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
    /* ===============================
     | RINGKASAN UTAMA
     =============================== */
    $totalOrder = Order::count();
    $totalCustomer = Customer::count();

    // Ambil data orders beserta items dan proses terakhir
    $orders = Order::with(['items.processes'])->get();

    // Hitung jumlah order berdasarkan status master (dari tabel order_statuses)
    $confirmedOrder = $orders->where('status', 'dikonfirmasi')->count();
    $completedOrder = $orders->where('status', 'selesai')->count();
    $cancelledOrder = $orders->where('status', 'dibatalkan')->count();

    // Hitung total revenue dari item yang proses terakhirnya sudah 'completed'
    $totalRevenue = 0;
    foreach ($orders as $order) {
        foreach ($order->items as $item) {
            $lastProcess = $item->processes->last();
            if ($lastProcess && $lastProcess->status === 'completed') {
                $totalRevenue += $item->subtotal + $item->options->sum('extra_price');
            }
        }
    }


        /* ===============================
         | ORDER TERBARU
         =============================== */
        $latestOrders = Order::with('customer')
            ->latest()
            ->limit(5)
            ->get();

        /* ===============================
         | TOP CUSTOMER
         =============================== */
        $topCustomers = Order::select(
                'customer_id',
                DB::raw('COUNT(id) as total_order'),
                DB::raw('SUM(total_price) as total_spent')
            )
            ->with('customer')
            ->groupBy('customer_id')
            ->orderByDesc('total_order')
            ->limit(5)
            ->get();

            // Chart data Top Customer
$topCustomerChart = $topCustomers->map(fn($item) => [
    'label' => $item->customer->name ?? 'Unknown',
    'value' => $item->total_order
]);

        /* ===============================
         | TOP PRODUK TERLARIS
         =============================== */
        $topProducts = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.qty) as total_sold')
            )
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

// Chart data Top Produk
$topProductChart = $topProducts->map(fn($item) => [
    'label' => $item->name,
    'value' => $item->total_sold
]);

        /* ===============================
         | CHART PROGRES PRODUKSI
         =============================== */
        $productionChart = OrderItemProcessLog::select(
                'status',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('status')
            ->get();

        return view('pages.dashboard', compact(
            'totalOrder',

            'confirmedOrder',
            'completedOrder',
            'cancelledOrder',
            'totalRevenue',
            'totalCustomer',
            'latestOrders',
            'topCustomers',
            'topProducts',
    'topCustomerChart',  // <-- wajib dikirim ke view
    'topProductChart'    // <-- wajib dikirim ke view
          
           
        ));
    }


}
