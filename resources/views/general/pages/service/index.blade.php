@extends('general.layouts.main')

@section('container')
    <div class="container py-5">
        <div class="text-center mb-4">
            <h2 class="text-secondary">Cek Status Perbaikan</h2>
            <p>Masukkan Kode Nota untuk mengetahui status layanan Anda.</p>
        </div>

        <form method="GET" class="mb-5">
            <div class="input-group">
                <input type="text" name="receipt_code" class="form-control" placeholder="Contoh: RCP202507001"
                    value="{{ request('receipt_code') }}" required>
                <button class="btn btn-primary" type="submit">Cek Status</button>
            </div>
        </form>

        @if (request('receipt_code') && !$repair)
            <div class="alert alert-danger text-center">
                Kode nota <strong>{{ request('receipt_code') }}</strong> tidak ditemukan.
            </div>
        @endif

        @if ($repair)
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Status Perbaikan - {{ $repair->receipt_code }}</h5>
                    <p class="mb-1">Laptop: <strong>{{ $repair->laptop->name }} {{ $repair->laptop->model }}</strong></p>
                    <p class="mb-1">Tanggal Masuk:
                        {{ \Carbon\Carbon::parse($repair->date_in)->translatedFormat('d F Y') }}</p>
                    <p class="mb-1">Status:
                        @php
                            $badge = match ($repair->service_state) {
                                'checking' => 'secondary',
                                'in progress' => 'warning',
                                'done' => 'info',
                                'taken back' => 'success',
                                default => 'dark',
                            };
                        @endphp
                        <span class="badge bg-{{ $badge }}">{{ ucfirst($repair->service_state) }}</span>
                    </p>

                    <p class="mb-1">Keluhan: {{ $repair->customer_complaint }}</p>
                    <p class="mb-1">Diagnosa: {{ $repair->problem ?? '-' }}</p>
                    <p class="mb-1">Layanan:
                    <ul class="mb-0">
                        @foreach ($repair->services as $service)
                            <li>{{ $service->name }} (Rp{{ number_format($service->price, 0, ',', '.') }})</li>
                        @endforeach
                    </ul>
                    </p>
                    <p class="mb-0">Total Biaya:
                        <strong>Rp{{ number_format($repair->total_price, 0, ',', '.') }}</strong>
                    </p>
                </div>
                <div class="text-end mt-3">
                    <a href="{{ route('general.invoice.export', $repair->receipt_code) }}" class="btn btn-outline-danger"
                        target="_blank">
                        <i class="fa fa-file-pdf"></i> Unduh Invoice
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
