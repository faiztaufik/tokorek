@extends('technician.layouts.main')
@section('container')
    <div class="card shadow mb-4">
        <div class="card-body">

            <!-- Filter Form -->
            <form method="GET" class="form-inline mb-4">
                <div class="form-group mr-2">
                    <label for="start_date" class="mr-2">Dari Tanggal</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="{{ request('start_date') }}">
                </div>
                <div class="form-group mr-2">
                    <label for="end_date" class="mr-2">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                        value="{{ request('end_date') }}">
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('technician.repair') }}" class="btn btn-secondary ml-2">Reset</a>
            </form>

            <!-- Export Button -->
            <div class="mb-3">
                <a href="{{ route('technician.repair.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                    class="btn btn-danger">
                    <i class="fa fa-file-pdf-o"></i> Export PDF
                </a>
            </div>


            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Nota</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Diambil</th>
                            <th>Customer</th>
                            <th>Teknisi</th>
                            <th>Laptop</th>
                            <th>Keluhan Customer</th>
                            <th>Diagnosa</th>
                            <th>Layanan Dikerjakan</th>
                            <th>Status</th>
                            <th>Total Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($repairs as $repair)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $repair->receipt_code }}</td>
                                <td>{{ \Carbon\Carbon::parse($repair->date_in)->format('d M Y') }}</td>
                                <td>{{ $repair->date_taken_back ? \Carbon\Carbon::parse($repair->date_taken_back)->format('d M Y') : '-' }}
                                </td>
                                <td>{{ $repair->customer_name }}</td>
                                <td>{{ $repair->technician->name }}</td>
                                <td>{{ $repair->laptop->name }}</td>
                                <td>{{ $repair->customer_complaint }}</td>
                                <td>{{ $repair->problem ?? '-' }}</td>
                                <td>
                                    <ul class="mb-0 pl-3">
                                        @forelse ($repair->services as $service)
                                            <li>{{ $service->name }} (Rp{{ number_format($service->price, 0, ',', '.') }})
                                            </li>
                                        @empty
                                            <li>-</li>
                                        @endforelse
                                    </ul>
                                </td>
                                <td>
                                    <span
                                        class="badge
                    @if ($repair->service_state === 'checking') badge-warning
                    @elseif ($repair->service_state === 'in progress') badge-primary
                    @elseif ($repair->service_state === 'done') badge-success
                    @elseif ($repair->service_state === 'taken back') badge-secondary @endif">
                                        {{ $repair->service_state }}
                                    </span>
                                </td>
                                <td>Rp{{ number_format($repair->total_price, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('technician.repair.show', $repair->id) }}"
                                        class="btn btn-sm btn-info">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">Tidak ada data perbaikan.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>



@endsection
