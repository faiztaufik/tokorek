<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Perbaikan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 4px;
            color: white;
        }

        .badge-warning {
            background-color: #f0ad4e;
        }

        .badge-primary {
            background-color: #007bff;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-secondary {
            background-color: #6c757d;
        }
    </style>
</head>

<body>
    <h2>Data Perbaikan</h2>
    @if ($start_date && $end_date)
        <p>Periode: {{ \Carbon\Carbon::parse($start_date)->format('d M Y') }} -
            {{ \Carbon\Carbon::parse($end_date)->format('d M Y') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Nota</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Diambil</th>
                <th>Customer</th>
                <th>Nomor Customer</th>
                <th>Teknisi</th>
                <th>Laptop</th>
                <th>Keluhan</th>
                <th>Masalah</th>
                <th>Status</th>
                <th>Detail Layanan</th>
                <th>Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($repairs as $repair)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $repair->receipt_code }}</td>
                    <td>{{ \Carbon\Carbon::parse($repair->date_in)->format('d M Y') }}</td>
                    <td>
                        {{ $repair->date_taken_back ? \Carbon\Carbon::parse($repair->date_taken_back)->format('d M Y') : '-' }}
                    </td>
                    <td>{{ $repair->customer_name }}</td>
                    <td>{{ $repair->customer_phone_number }}</td>
                    <td>{{ $repair->technician->name }}</td>
                    <td>{{ $repair->laptop->name }}</td>
                    <td>{{ $repair->customer_complaint }}</td>
                    <td>{{ $repair->problem ?? '-' }}</td>
                    <td>
                        <span
                            class="badge 
                            @if ($repair->service_state == 'checking') badge-warning
                            @elseif ($repair->service_state == 'in progress') badge-primary
                            @elseif ($repair->service_state == 'done') badge-success
                            @elseif ($repair->service_state == 'taken back') badge-secondary @endif
                        ">
                            {{ $repair->service_state }}
                        </span>
                    </td>
                    <td>
                        @if ($repair->services && $repair->services->count())
                            <ul style="padding-left: 18px; margin: 0;">
                                @foreach ($repair->services as $service)
                                    <li>{{ $service->name }} (Rp{{ number_format($service->price, 0, ',', '.') }})
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </td>
                    <td>Rp{{ number_format($repair->total_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" style="text-align: center;">Tidak ada data perbaikan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
