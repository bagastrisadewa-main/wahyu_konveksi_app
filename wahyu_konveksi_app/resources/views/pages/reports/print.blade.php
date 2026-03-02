<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 20px;
        }

        .header, .footer {
            text-align: center;
        }

        .header img {
            width: 60px;
            height: auto;
        }

        .header h2, .header p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

     .footer {
        text-align: center;
        margin-top: 30px;
        font-size: 12px;
        color: #555;
    }

    @media print {
        .footer {
            page-break-after: always;
        }
    }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
<img src="{{ asset($appSettings['store_logo'] 
        ? 'storage/settings/' . $appSettings['store_logo'] 
        : 'img/default-logo.png') }}" 
     alt="Logo" style="height: 60px;">


        <h2>WHSKonveksindo</h2>
        <p><strong>Laporan Penjualan</strong></p>
    </div>

    {{-- Tabel Data --}}

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

<div class="footer">
    <hr>
    <p>Alamat: {{ $appSettings['store_address'] ?? '-' }}</p>

    @if (!empty($appSettings['store_phone']))
        <p>
            WhatsApp:
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $appSettings['store_phone']) }}" target="_blank">
                {{ $appSettings['store_phone'] }}
            </a>
        </p>
    @endif

    <p>
        @if (!empty($appSettings['store_instagram']))
            <a href="{{ $appSettings['store_instagram'] }}" target="_blank">Instagram</a>
        @endif

        @if (!empty($appSettings['store_tiktok']))
            | <a href="{{ $appSettings['store_tiktok'] }}" target="_blank">TikTok</a>
        @endif
    </p>
</div>

</body>
</html>

<script>
    window.onload = function () {
        window.print();
    }
</script>

