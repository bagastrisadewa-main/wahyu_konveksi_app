@extends('layouts.app')
@section('title', 'Dashboard')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header"><h1>Dashboard WHS Konveksi</h1></div>

       {{-- ================= SUMMARY CARDS ================= --}}
<div class="row mb-4 g-3">

 <div class="col-md-2">
        <div class="card text-white bg-primary shadow-sm rounded-10 h-100">
            <div class="card-body text-center">
                <i class="fas fa-shopping-cart fa-4x mb-2"></i>
                <h6 class="mb-2">Total Order</h6>
                <h3 class="mb-0">{{ $totalOrder }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card text-white bg-primary shadow-sm rounded-10 h-100">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-4x mb-2"></i>
                <h6 class="mb-2">Dikonfirmasi</h6>
                <h3 class="mb-0">{{ $confirmedOrder }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card text-white bg-success shadow-sm rounded-10 h-100">
            <div class="card-body text-center">
                <i class="fas fa-box fa-4x mb-2"></i>
                <h6 class="mb-2">Selesai</h6>
                <h3 class="mb-0">{{ $completedOrder }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card text-white bg-danger shadow-sm rounded-10 h-100">
            <div class="card-body text-center">
                <i class="fas fa-times-circle fa-4x mb-2"></i>
                <h6 class="mb-2">Dibatalkan</h6>
                <h3 class="mb-0">{{ $cancelledOrder }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card text-white bg-info shadow-sm rounded-10 h-100">
            <div class="card-body text-center">
                <i class="fas fa-users fa-4x mb-2"></i>
                <h6 class="mb-2">Total Customer</h6>
                <h3 class="mb-0">{{ $totalCustomer }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card text-white bg-success shadow-sm rounded-10 h-100">
            <div class="card-body text-center">
                <i class="fas fa-wallet fa-2x mb-2"></i>
                <h6 class="mb-2">Total Omset</h6>
                <h4 class="mb-0">Rp {{ number_format($totalRevenue,0,',','.') }}</h4>
            </div>
        </div>
    </div>

</div>


          {{-- ================= CHART ================= --}}
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header"><strong>Top Produk Terlaris</strong></div>
            <div class="card-body">
                <canvas id="topProductChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header"><strong>Top Customer</strong></div>
            <div class="card-body">
                <canvas id="topCustomerChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>



        {{-- ================= TABLES ================= --}}
        <div class="row">
            {{-- Latest Orders --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header"><strong>Order Terbaru</strong></div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($latestOrders as $order)
                                <tr>
                                    <td>{{ $order->order_code }}</td>
                                    <td>{{ $order->customer->name ?? '-' }}</td>
                                    <td>
                                        @php
                                            $statusClass = match($order->status) {
                                                'completed' => 'primary',
                                                'draft' => 'primary',
                                                'confirmed' => 'primary',
                                                'cancelled' => 'primary',
                                                default => 'primary'
                                            };
                                        @endphp
                                       <span class="badge bg-{{ $statusClass }} text-white">{{ ucfirst($order->status) }}</span>
                                    <td>Rp {{ number_format($order->total_price,0,',','.') }}</td>
                                    <td>{{ date('d M Y', strtotime($order->transaction_time)) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada order</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Top Customers --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header"><strong>Top Customer</strong></div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Total Order</th>
                                    <th>Total Belanja</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($topCustomers as $row)
                                <tr>
                                    <td>{{ $row->customer->name ?? '-' }}</td>
                                    <td>{{ $row->total_order }}</td>
                                    <td>Rp {{ number_format($row->total_spent,0,',','.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Data kosong</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Top Products --}}
            <div class="col-md-12 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header"><strong>Produk Terlaris</strong></div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($topProducts as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->total_sold }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Belum ada data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ================= CHART ORDER & REVENUE =================
 // ======= Top Customer Doughnut Chart =======
const topCustomerData = @json($topCustomerChart ?? []);
const customerLabels = topCustomerData.map(item => item.label);
const customerValues = topCustomerData.map(item => item.value);

new Chart(document.getElementById('topCustomerChart'), {
    type: 'doughnut',
    data: {
        labels: customerLabels,
        datasets: [{
            data: customerValues,
            backgroundColor: ['#36A2EB','#FF6384','#FFCE56','#4BC0C0','#9966FF']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } }
    }
});

// ======= Top Produk Bar Chart =======
const topProductData = @json($topProductChart ?? []);
const productLabels = topProductData.map(item => item.label);
const productValues = topProductData.map(item => item.value);

new Chart(document.getElementById('topProductChart'), {
    type: 'bar', // <-- ini ganti dari doughnut ke bar
    data: {
        labels: productLabels,
        datasets: [{
            label: 'Jumlah Terjual',
            data: productValues,
            backgroundColor: '#36A2EB'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true }
        }
    }
});


</script>
@endpush


