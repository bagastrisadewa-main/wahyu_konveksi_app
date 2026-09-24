<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItemProcessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /* ===============================
         | FILTER PERIODE
         =============================== */
        $period = $request->get('period', 'all'); // all | today | week | month | custom
        $from   = $request->get('from');
        $to     = $request->get('to');

        [$startDate, $endDate] = match($period) {
            'today' => [Carbon::today(), Carbon::today()->endOfDay()],
            'week'  => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'month' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            'custom' => [
                $from ? Carbon::parse($from)->startOfDay() : Carbon::now()->startOfMonth(),
                $to ? Carbon::parse($to)->endOfDay() : Carbon::now()->endOfDay(),
            ],
            default => [null, null], // 'all' → tanpa filter
        };

        $applyPeriod = function ($query) use ($startDate, $endDate) {
            if ($startDate && $endDate) {
                $query->whereBetween('transaction_time', [$startDate, $endDate]);
            }
            return $query;
        };

        /* ===============================
         | RINGKASAN UTAMA
         =============================== */
        $totalOrder    = $applyPeriod(Order::query())->count();
        $totalCustomer = Customer::count(); // total customer terdaftar, tidak terikat periode

        $orders = $applyPeriod(Order::with(['items.processes', 'items.options']))->get();

        $confirmedOrder = $orders->where('status', 'dikonfirmasi')->count();
        $completedOrder = $orders->where('status', 'selesai')->count();
        $cancelledOrder = $orders->where('status', 'dibatalkan')->count();

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
        $latestOrders = $applyPeriod(Order::with('customer'))
            ->latest()
            ->limit(5)
            ->get();

        /* ===============================
         | TOP CUSTOMER
         =============================== */
        $topCustomers = $applyPeriod(Order::select(
                'customer_id',
                DB::raw('COUNT(id) as total_order'),
                DB::raw('SUM(total_price) as total_spent')
            ))
            ->with('customer')
            ->groupBy('customer_id')
            ->orderByDesc('total_order')
            ->limit(5)
            ->get();

        $topCustomerChart = $topCustomers->map(fn($item) => [
            'label' => $item->customer->name ?? 'Unknown',
            'value' => $item->total_order
        ]);

        /* ===============================
         | TOP PRODUK TERLARIS
         =============================== */
        $topProductsQuery = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.qty) as total_sold')
            )
            ->groupBy('products.name')
            ->orderByDesc('total_sold');

        if ($startDate && $endDate) {
            $topProductsQuery->whereBetween('orders.transaction_time', [$startDate, $endDate]);
        }

        $topProducts = $topProductsQuery->limit(5)->get();

        $topProductChart = $topProducts->map(fn($item) => [
            'label' => $item->name,
            'value' => $item->total_sold
        ]);

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
            'topCustomerChart',
            'topProductChart',
            'period',
            'from',
            'to'
        ));
    }
}