@extends('layouts.app')
@section('title', 'Dashboard')

@section('main')
<div class="main-content">
    <section class="section">

        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <p class="text-muted dashboard-subtitle">Ringkasan performa {{ $appSettings['store_name'] ?? 'toko' }}</p>

        {{-- ================= FILTER PERIODE ================= --}}
        <div class="period-filter mb-4">
            <div class="btn-group flex-wrap" role="group">
                <a href="{{ route('dashboard', ['period' => 'all']) }}"
                   class="btn btn-period {{ $period === 'all' ? 'active' : '' }}">Semua Waktu</a>
                <a href="{{ route('dashboard', ['period' => 'today']) }}"
                   class="btn btn-period {{ $period === 'today' ? 'active' : '' }}">Hari Ini</a>
                <a href="{{ route('dashboard', ['period' => 'week']) }}"
                   class="btn btn-period {{ $period === 'week' ? 'active' : '' }}">Minggu Ini</a>
                <a href="{{ route('dashboard', ['period' => 'month']) }}"
                   class="btn btn-period {{ $period === 'month' ? 'active' : '' }}">Bulan Ini</a>
                <button type="button"
                        class="btn btn-period {{ $period === 'custom' ? 'active' : '' }}"
                        id="btnToggleCustomDate">
                    <i class="fas fa-calendar-alt me-1"></i>
                    @if($period === 'custom' && $from && $to)
                        {{ \Carbon\Carbon::parse($from)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($to)->translatedFormat('d M Y') }}
                    @else
                        Custom
                    @endif
                </button>
            </div>
        </div>

        {{-- ================= SUMMARY CARDS ================= --}}
        <div class="row mb-4 g-4">

            <div class="col-6 col-md-4 col-xl-2">
                <div class="stat-card stat-card--blue h-100">
                    <div class="stat-card__icon"><i class="fas fa-shopping-cart"></i></div>
                    <div class="stat-card__value">{{ $totalOrder }}</div>
                    <div class="stat-card__label">Total Order</div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2">
                <div class="stat-card stat-card--purple h-100">
                    <div class="stat-card__icon"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-card__value">{{ $confirmedOrder }}</div>
                    <div class="stat-card__label">Dikonfirmasi</div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2">
                <div class="stat-card stat-card--green h-100">
                    <div class="stat-card__icon"><i class="fas fa-box"></i></div>
                    <div class="stat-card__value">{{ $completedOrder }}</div>
                    <div class="stat-card__label">Selesai</div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2">
                <div class="stat-card stat-card--red h-100">
                    <div class="stat-card__icon"><i class="fas fa-times-circle"></i></div>
                    <div class="stat-card__value">{{ $cancelledOrder }}</div>
                    <div class="stat-card__label">Dibatalkan</div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2">
                <div class="stat-card stat-card--teal h-100">
                    <div class="stat-card__icon"><i class="fas fa-users"></i></div>
                    <div class="stat-card__value">{{ $totalCustomer }}</div>
                    <div class="stat-card__label">Total Customer</div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2">
                <div class="stat-card stat-card--theme h-100">
                    <div class="stat-card__icon"><i class="fas fa-wallet"></i></div>
                    <div class="stat-card__value stat-card__value--sm">Rp {{ number_format($totalRevenue,0,',','.') }}</div>
                    <div class="stat-card__label">Total Omset</div>
                </div>
            </div>

        </div>

        {{-- ================= CHART ================= --}}
        <div class="row mb-4 g-4">
            <div class="col-md-6">
                <div class="chart-card h-100">
                    <div class="chart-card__header">
                        <div>
                            <h6 class="mb-0">Top Produk Terlaris</h6>
                            <small class="text-muted">5 produk dengan penjualan tertinggi</small>
                        </div>
                        <span class="chart-card__badge"><i class="fas fa-chart-bar"></i></span>
                    </div>
                    <div class="chart-card__body">
                        @if($topProductChart->isEmpty())
                            <div class="chart-empty">Belum ada data penjualan</div>
                        @else
                            <canvas id="topProductChart" height="220"></canvas>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="chart-card h-100">
                    <div class="chart-card__header">
                        <div>
                            <h6 class="mb-0">Top Customer</h6>
                            <small class="text-muted">5 pelanggan dengan order terbanyak</small>
                        </div>
                        <span class="chart-card__badge"><i class="fas fa-chart-pie"></i></span>
                    </div>
                    <div class="chart-card__body">
                        @if($topCustomerChart->isEmpty())
                            <div class="chart-empty">Belum ada data customer</div>
                        @else
                            <canvas id="topCustomerChart" height="220"></canvas>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= TABLE: ORDER TERBARU + TOP CUSTOMER ================= --}}
        <div class="row g-4 mb-4">

            {{-- Latest Orders --}}
            <div class="col-md-6">
                <div class="table-card h-100">
                    <div class="table-card__header">
                        <h6 class="mb-0">Order Terbaru</h6>
                        <a href="{{ route('orders.index') }}" class="table-card__link">
                            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($latestOrders as $order)
                                @php
                                    $statusClass = match($order->status) {
                                        'selesai' => 'success',
                                        'dikonfirmasi' => 'primary',
                                        'menunggu_konfirmasi' => 'warning',
                                        'dibatalkan' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <tr>
                                    <td class="fw-semibold">{{ $order->order_code }}</td>
                                    <td>{{ $order->customer->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $statusClass }} text-white rounded-pill px-3 py-2">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($order->total_price,0,',','.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->transaction_time)->translatedFormat('d M Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('orders.show', $order->id) }}"
                                           class="btn btn-sm btn-outline-theme rounded-pill px-3">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada order</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Top Customers --}}
            <div class="col-md-6">
                <div class="table-card h-100">
                    <div class="table-card__header">
                        <h6 class="mb-0">Top Customer</h6>
                        <a href="{{ route('customers.index') }}" class="table-card__link">
                            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Total Order</th>
                                    <th>Total Belanja</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($topCustomers as $i => $row)
                                <tr>
                                    <td>
                                        <span class="rank-badge rank-badge--{{ $i + 1 }}">{{ $i + 1 }}</span>
                                    </td>
                                    <td class="fw-semibold">{{ $row->customer->name ?? '-' }}</td>
                                    <td>{{ $row->total_order }}</td>
                                    <td>Rp {{ number_format($row->total_spent,0,',','.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Data kosong</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- ================= TABLE: PRODUK TERLARIS ================= --}}
        <div class="row g-4">
            <div class="col-12">
                <div class="table-card">
                    <div class="table-card__header">
                        <h6 class="mb-0">Produk Terlaris</h6>
                        <a href="{{ route('product.index') }}" class="table-card__link">
                            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Produk</th>
                                    <th>Terjual</th>
                                    <th>Progres</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $maxSold = $topProducts->max('total_sold') ?: 1; @endphp
                            @forelse($topProducts as $i => $product)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="fw-semibold">{{ $product->name }}</td>
                                    <td>{{ $product->total_sold }}</td>
                                    <td style="min-width:160px;">
                                        <div class="progress-bar-track">
                                            <div class="progress-bar-fill"
                                                 style="width: {{ ($product->total_sold / $maxSold) * 100 }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada data</td>
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

{{-- ================= MODAL CUSTOM DATE RANGE ================= --}}
<div class="dashboard-modal-overlay" id="customDateModalOverlay">
    <div class="dashboard-modal">
        <div class="dashboard-modal__header">
            <h6 class="mb-0">Pilih Rentang Tanggal</h6>
            <button type="button" class="dashboard-modal__close" id="btnCloseCustomDate">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="GET" action="{{ route('dashboard') }}" class="dashboard-modal__body">
            <input type="hidden" name="period" value="custom">

            <div class="mb-3">
                <label class="form-label fw-semibold">Dari Tanggal</label>
                <input type="text" name="from" id="filterFrom" value="{{ $from }}"
                       class="form-control" placeholder="Pilih tanggal mulai" autocomplete="off" readonly>
            </div>

            <div class="mb-2">
                <label class="form-label fw-semibold">Sampai Tanggal</label>
                <input type="text" name="to" id="filterTo" value="{{ $to }}"
                       class="form-control" placeholder="Pilih tanggal akhir" autocomplete="off" readonly>
            </div>

            <small class="text-danger d-none mb-3 d-block" id="dateRangeError">
                Tanggal akhir tidak boleh sebelum tanggal mulai.
            </small>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('dashboard', ['period' => 'all']) }}" class="btn btn-light rounded-pill px-4">
                    <i class="fas fa-undo me-1"></i> Reset
                </a>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4" id="btnCancelCustomDate">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-theme rounded-pill px-4" id="btnApplyCustomDate">
                        Terapkan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ================= STYLE ================= --}}
<style>
/* ===== Stat Cards ===== */
.stat-card {
    border-radius: 18px;
    padding: 20px 16px;
    color: #fff;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 28px rgba(0,0,0,0.14);
}

.stat-card__icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    margin-bottom: 14px;
}

.stat-card__value {
    font-size: 1.6rem;
    font-weight: 700;
    line-height: 1.1;
}

.stat-card__value--sm {
    font-size: 1.15rem;
}

.stat-card__label {
    font-size: 0.82rem;
    opacity: 0.9;
    margin-top: 4px;
}

.stat-card--blue   { background: linear-gradient(135deg, #4facfe 0%, #3a7bd5 100%); }
.stat-card--purple { background: linear-gradient(135deg, #a18cd1 0%, #6a4dbb 100%); }
.stat-card--green  { background: linear-gradient(135deg, #43e97b 0%, #2a9d5c 100%); }
.stat-card--red    { background: linear-gradient(135deg, #f77062 0%, #c93a30 100%); }
.stat-card--teal   { background: linear-gradient(135deg, #38f9d7 0%, #1e9c8c 100%); }
.stat-card--theme  { background: linear-gradient(135deg, #6777ef 0%, #4e5fd1 100%); }

/* ===== Chart Cards ===== */
.chart-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    padding: 20px;
    transition: background 0.2s ease;
}

.chart-card__header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.chart-card__badge {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #f1f3f9;
    color: #6777ef;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chart-empty {
    text-align: center;
    color: #999;
    padding: 60px 0;
    font-size: 0.9rem;
}

/* ===== Table Cards ===== */
.table-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    overflow: hidden;
    transition: background 0.2s ease;
}

.table-card__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 20px;
    border-bottom: 1px solid #f0f0f0;
}

.table-card__link {
    font-size: 0.82rem;
    font-weight: 600;
    color: #6777ef;
    text-decoration: none;
}

.table-card__link:hover {
    text-decoration: underline;
}

.table-card table th {
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.02em;
    color: #999;
    border-top: none;
    padding: 12px 20px;
}

.table-card table td {
    padding: 12px 20px;
    font-size: 0.88rem;
}

/* ===== Rank Badge (Top Customer) ===== */
.rank-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    font-size: 0.78rem;
    font-weight: 700;
    background: #f1f3f9;
    color: #666;
}

.rank-badge--1 { background: #ffd700; color: #6b5400; }
.rank-badge--2 { background: #c0c0c0; color: #4a4a4a; }
.rank-badge--3 { background: #cd7f32; color: #4a2e11; }

/* ===== Progress Bar (Produk Terlaris) ===== */
.progress-bar-track {
    width: 100%;
    height: 8px;
    background: #f1f3f9;
    border-radius: 20px;
    overflow: hidden;
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #6777ef, #4e5fd1);
    border-radius: 20px;
    transition: width 0.4s ease;
}

/* ===== Period Filter ===== */
.btn-period {
    background: #fff;
    border: 1px solid #e5e5e5;
    color: #555;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 8px 18px;
    border-radius: 30px !important;
    margin-right: 6px;
    margin-bottom: 6px;
    transition: all 0.2s ease;
}

/* Hover selalu jadi lebih pekat/berwarna, bukan lebih terang */
.btn-period:hover {
    background: #eef0fd;
    border-color: #6777ef;
    color: #6777ef;
}
.btn-period.active {
    background: #6777ef !important;
    border-color: #6777ef !important;
    color: #fff !important;
}

.btn-period.active:hover {
    background: #6777ef !important;
    border-color: #6777ef !important;
    color: #fff !important;
}
.dashboard-subtitle {
    margin-top: -8px;
    margin-bottom: 20px;
    display: block;
}

/* ===== Tombol tema (Stisla-style) ===== */
.btn-theme {
    background: #6777ef;
    border: 1px solid #6777ef;
    color: #fff;
    font-weight: 600;
    transition: background 0.2s ease, border-color 0.2s ease;
}

.btn-theme:hover {
    background: #4e5fd1;
    border-color: #4e5fd1;
    color: #fff;
}

.btn-theme:disabled {
    background: #b7bdf8;
    border-color: #b7bdf8;
    cursor: not-allowed;
}

.btn-outline-theme {
    border: 1px solid #6777ef !important;
    color: #6777ef !important;
    background: transparent !important;
    font-weight: 600;
    transition: background 0.2s ease, color 0.2s ease;
}

.btn-outline-theme:hover {
    background: #6777ef !important;
    border-color: #6777ef !important;
    color: #fff !important;
}

/* ===== Modal Custom Date Range ===== */
.dashboard-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    z-index: 10000;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

.dashboard-modal-overlay.show {
    display: flex;
}

.dashboard-modal {
    background: #fff;
    border-radius: 18px;
    width: 100%;
    max-width: 380px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.25);
    overflow: hidden;
    animation: modalPop 0.2s ease;
}

@keyframes modalPop {
    from { transform: scale(0.94); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.dashboard-modal__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 20px;
    border-bottom: 1px solid #f0f0f0;
}

.dashboard-modal__close {
    background: none;
    border: none;
    color: #999;
    font-size: 1rem;
    cursor: pointer;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s ease;
}

.dashboard-modal__close:hover {
    background: #f1f3f9;
    color: #333;
}

.dashboard-modal__body {
    padding: 20px;
}

/* Flatpickr menyesuaikan warna tema */
.flatpickr-day.selected,
.flatpickr-day.selected:hover,
.flatpickr-day.startRange,
.flatpickr-day.endRange {
    background: #6777ef;
    border-color: #6777ef;
}

.flatpickr-day.inRange {
    background: #eef0fd;
    border-color: #eef0fd;
    box-shadow: -5px 0 0 #eef0fd, 5px 0 0 #eef0fd;
}

/* ============================================================
   DARK MODE — mengikuti toggleTheme() yang toggle body.dark-mode
   ============================================================ */
body.dark-mode .chart-card,
body.dark-mode .table-card {
    background: #1e1e2d;
    box-shadow: 0 6px 18px rgba(0,0,0,0.3);
}

body.dark-mode .chart-card__header,
body.dark-mode .table-card__header {
    border-bottom-color: rgba(255,255,255,0.08);
}

body.dark-mode .chart-card h6,
body.dark-mode .table-card h6,
body.dark-mode .dashboard-modal__header h6,
body.dark-mode .section-header h1 {
    color: #e4e6ef;
}

body.dark-mode .dashboard-subtitle {
    color: #a2a5b9 !important;
}

body.dark-mode .chart-card__badge {
    background: rgba(103,119,239,0.15);
}

body.dark-mode .table-card table th {
    color: #a2a5b9;
}

body.dark-mode .table-card table td {
    color: #cfd2e3;
}

body.dark-mode .table-hover > tbody > tr:hover > * {
    background: rgba(255,255,255,0.04);
    color: #fff;
}

body.dark-mode .chart-empty {
    color: #6c6c80;
}

body.dark-mode .progress-bar-track {
    background: rgba(255,255,255,0.08);
}

body.dark-mode .rank-badge {
    background: rgba(255,255,255,0.08);
    color: #cfd2e3;
}

body.dark-mode .btn-period {
    background: #1e1e2d;
    border-color: rgba(255,255,255,0.1);
    color: #cfd2e3;
}

body.dark-mode .btn-outline-theme {
    color: #8b96f7;
    border-color: #8b96f7;
}

body.dark-mode .dashboard-modal {
    background: #1e1e2d;
}

body.dark-mode .dashboard-modal__header {
    border-bottom-color: rgba(255,255,255,0.08);
}

body.dark-mode .dashboard-modal__close {
    color: #cfd2e3;
}

body.dark-mode .dashboard-modal__close:hover {
    background: rgba(255,255,255,0.08);
}

body.dark-mode .dashboard-modal .form-label {
    color: #cfd2e3;
}

body.dark-mode .dashboard-modal .form-control {
    background: #262637;
    border-color: rgba(255,255,255,0.1);
    color: #fff;
}

body.dark-mode .btn-light {
    background: #2a2a3d;
    border-color: rgba(255,255,255,0.1);
    color: #cfd2e3;
}

body.dark-mode .btn-light:hover {
    background: #33334a;
    color: #fff;
}

body.dark-mode .btn-period:hover {
    background: rgba(103,119,239,0.15);
    border-color: #8b96f7;
    color: #8b96f7;
}
</style>
@endsection

@push('scripts')
{{-- Flatpickr — date picker modern + locale Indonesia --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
Chart.defaults.font.family = "'Nunito', sans-serif";

const topCustomerData = @json($topCustomerChart ?? []);
if (topCustomerData.length) {
    new Chart(document.getElementById('topCustomerChart'), {
        type: 'doughnut',
        data: {
            labels: topCustomerData.map(item => item.label),
            datasets: [{
                data: topCustomerData.map(item => item.value),
                backgroundColor: ['#6777ef','#a18cd1','#43e97b','#f77062','#38f9d7'],
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 10, padding: 14, font: { size: 11 } }
                }
            }
        }
    });
}

const topProductData = @json($topProductChart ?? []);
if (topProductData.length) {
    new Chart(document.getElementById('topProductChart'), {
        type: 'bar',
        data: {
            labels: topProductData.map(item => item.label),
            datasets: [{
                label: 'Jumlah Terjual',
                data: topProductData.map(item => item.value),
                backgroundColor: '#6777ef',
                borderRadius: 8,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f3f9' } },
                x: { grid: { display: false } }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    flatpickr.localize(flatpickr.l10ns.id);

    const fromPicker = flatpickr('#filterFrom', {
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'd F Y',
        locale: 'id',
        disableMobile: true,
        onChange: function (selectedDates) {
            if (selectedDates[0]) {
                toPicker.set('minDate', selectedDates[0]);

                const toDate = toPicker.selectedDates[0];
                if (toDate && toDate < selectedDates[0]) {
                    toPicker.clear();
                }
            }
            validateDateRange();
        }
    });

    const toPicker = flatpickr('#filterTo', {
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'd F Y',
        locale: 'id',
        disableMobile: true,
        onChange: function () {
            validateDateRange();
        }
    });

    const errorMsg = document.getElementById('dateRangeError');
    const applyBtn = document.getElementById('btnApplyCustomDate');

    function validateDateRange() {
        const fromVal = fromPicker.selectedDates[0];
        const toVal = toPicker.selectedDates[0];

        if (fromVal && toVal && toVal < fromVal) {
            errorMsg.classList.remove('d-none');
            applyBtn.disabled = true;
            return false;
        }

        errorMsg.classList.add('d-none');
        applyBtn.disabled = false;
        return true;
    }

    @if($from)
        toPicker.set('minDate', "{{ $from }}");
    @endif

    document.querySelector('.dashboard-modal__body').addEventListener('submit', function (e) {
        if (!validateDateRange()) {
            e.preventDefault();
        }
    });

    const overlay = document.getElementById('customDateModalOverlay');
    const btnOpen = document.getElementById('btnToggleCustomDate');
    const btnClose = document.getElementById('btnCloseCustomDate');
    const btnCancel = document.getElementById('btnCancelCustomDate');

    function openModal() {
        overlay.classList.add('show');
    }

    function closeModal() {
        overlay.classList.remove('show');
    }

    if (btnOpen) btnOpen.addEventListener('click', openModal);
    if (btnClose) btnClose.addEventListener('click', closeModal);
    if (btnCancel) btnCancel.addEventListener('click', closeModal);

    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closeModal();
    });
});
</script>
@endpush