<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Setting;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use PDF;
use Illuminate\Support\Str;
use App\Models\OrderStatus;

class ReportController extends Controller
{
    // Halaman laporan
    public function index(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $orders = Order::with(['items.product', 'customer'])
            ->when($start, fn($q) => $q->whereDate('transaction_time', '>=', $start))
            ->when($end, fn($q) => $q->whereDate('transaction_time', '<=', $end))
            ->latest()
            ->get();

                // ✅ ambil master status
           $statuses = OrderStatus::where('is_active', 1)->get();

       return view('pages.reports.index', compact('orders', 'statuses'));
    }

    // Export Excel
    public function exportExcel(Request $request)
    {
        return Excel::download(new OrdersExport($request), 'laporan_order.xlsx');
    }

    // Export PDF
    public function exportPdf(Request $request)
    {
        $orders = (new OrdersExport($request))->collection();
        $appSettings = Setting::all()->pluck('value', 'key')->toArray();

        $namaToko = $appSettings['store_name'] ?? 'Yans POS';
        $slugToko = Str::slug($namaToko, '_');
        $tanggal = now()->format('dmY');
        $filename = 'laporan_order_' . $slugToko . '_' . $tanggal . '.pdf';

        $pdf = PDF::loadView('pages.reports.pdf', compact('orders', 'appSettings'));
        return $pdf->download($filename);
    }

    // Print
    public function print(Request $request)
    {
        $orders = (new OrdersExport($request))->collection();
        $appSettings = Setting::all()->pluck('value', 'key')->toArray();

        return view('pages.reports.print', compact('orders', 'appSettings'));
    }
}
