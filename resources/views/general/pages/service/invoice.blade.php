<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $repair->receipt_code }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        .header,
        .footer {
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .right {
            text-align: right;
        }

        .info {
            margin-top: 20px;
        }

        .info p {
            margin: 4px 0;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>INVOICE PERBAIKAN</h2>
        <p>Kode Nota: {{ $repair->receipt_code }}</p>
    </div>

    <hr>

    <div class="info">
        <p><strong>Tanggal Masuk:</strong> {{ \Carbon\Carbon::parse($repair->date_in)->translatedFormat('d F Y') }}</p>
        @if ($repair->date_taken_back)
            <p><strong>Tanggal Diambil:</strong>
                {{ \Carbon\Carbon::parse($repair->date_taken_back)->translatedFormat('d F Y') }}</p>
        @endif
        <p><strong>Status:</strong> {{ ucfirst($repair->service_state) }}</p>
        <p><strong>Nama Customer:</strong> {{ $repair->customer_name }}</p>
        <p><strong>No. Telepon:</strong> {{ $repair->customer_phone_number }}</p>
        <p><strong>Laptop:</strong> {{ $repair->laptop->name }} - {{ $repair->model }}</p>
        <p><strong>Teknisi:</strong> {{ $repair->technician->name }}</p>
        <p><strong>Keluhan:</strong> {{ $repair->customer_complaint }}</p>
        <p><strong>Diagnosa:</strong> {{ $repair->problem ?? '-' }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Layanan</th>
                <th class="right">Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($repair->services as $index => $service)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $service->name }}</td>
                    <td class="right">Rp{{ number_format($service->price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Belum ada layanan yang ditambahkan.</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="2"><strong>Total Biaya</strong></td>
                <td class="right"><strong>Rp{{ number_format($repair->total_price, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer" style="margin-top: 40px;">
        <p>Terima kasih telah mempercayakan layanan kami.</p>
    </div>

</body>

</html>
