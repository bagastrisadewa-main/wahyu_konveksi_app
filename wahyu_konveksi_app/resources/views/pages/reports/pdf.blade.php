<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 0; padding: 0; }

        .container {
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .logo {
            height: 50px;
            margin-bottom: 5px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 14px;
            margin-top: -5px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            color: #555;
            border-top: 1px solid #ccc;
            margin-top: 30px;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        {{-- Header --}}
        <div class="header">
@php
    $logoPath = $appSettings['store_logo'] ?? null;
    $logoFile = $logoPath && file_exists(public_path('storage/settings/' . $logoPath))
        ? public_path('storage/settings/' . $logoPath)
        : public_path('img/default-logo.png');

    $logoType = pathinfo($logoFile, PATHINFO_EXTENSION);
    $logoData = base64_encode(file_get_contents($logoFile));
    $src = 'data:image/' . $logoType . ';base64,' . $logoData;
@endphp

<img src="{{ $src }}" alt="Logo" style="height: 60px;">

            <div class="title">WHSKonveksindo</div>
            <div class="subtitle">Laporan Penjualan</div>
        </div>

        {{-- Tabel Data --}}
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Order</th>
            <th>Produk</th>
            <th>Customer</th>
            <th>Transaction Time</th>
            <th>Total Item</th>
            <th>Total Price</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $i => $order)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $order['Kode Order'] }}</td>
                <td>{{ $order['Produk'] }}</td>
                <td>{{ $order['Customer'] }}</td>
                <td>{{ $order['Tanggal'] }}</td>
                <td>{{ $order['Total Item'] }}</td>
                <td>Rp {{ number_format($order['Total'], 0, ',', '.') }}</td>
                <td>{{ $order['Status'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>



        {{-- Footer --}}
<<div class="footer">
    {{ $appSettings['store_name'] ?? 'Yans POS' }} &copy; {{ now()->year }}<br>
    {{ $appSettings['store_address'] ?? '-' }}<br>

    @if (!empty($appSettings['store_phone']))
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $appSettings['store_phone']) }}" target="_blank">
            WhatsApp: {{ $appSettings['store_phone'] }}
        </a><br>
    @endif

    @if (!empty($appSettings['store_instagram']))
        <a href="{{ $appSettings['store_instagram'] }}" target="_blank">Instagram</a>
    @endif

    @if (!empty($appSettings['store_tiktok']))
        | <a href="{{ $appSettings['store_tiktok'] }}" target="_blank">TikTok</a>
    @endif
</div>

</body>
</html>
