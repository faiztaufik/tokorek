@extends('admin.layouts.main')
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
                <a href="{{ route('admin.repair') }}" class="btn btn-secondary ml-2">Reset</a>
            </form>            
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addRepairModal">
                <i class="fa fa-plus"></i> Tambah Perbaikan
            </button>

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
                                    <a href="{{ route('admin.repair.show', $repair->id) }}"
                                        class="btn btn-sm btn-info mb-2">Detail</a>
                                    <a href="{{ route('admin.repair.invoice', $repair->receipt_code) }}" 
                                    class="btn btn-sm btn-danger" target="_blank">Invoice</a>
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

    <!-- Modal -->
    <div class="modal fade" id="addRepairModal" tabindex="-1" role="dialog" aria-labelledby="addRepairModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('admin.repair.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data Perbaikan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label for="customer_name">Nama Customer</label>
                            <input type="text" name="customer_name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="customer_phone_number">No. Telepon Customer</label>
                            <input type="text" name="customer_phone_number" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="laptop_id">Laptop</label>
                            <select name="laptop_id" class="form-control select2-modal" required>
                                <option disabled selected>Pilih Laptop</option>
                                @foreach ($laptops as $laptop)
                                    <option value="{{ $laptop->id }}">{{ $laptop->name }} - {{ $laptop->model }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="model">Model Laptop</label>
                            <input type="text" name="model" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="customer_complaint">Keluhan Customer</label>
                            <textarea name="customer_complaint" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="technician_id">Teknisi</label>
                            <select name="technician_id" class="form-control select2-modal" required>
                                <option disabled selected>Pilih Teknisi</option>
                                @foreach ($technicians as $technician)
                                    <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="problem">Diagnosa Teknisi</label>
                            <textarea name="problem" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="service_state">Status</label>
                            <select name="service_state" class="form-control" required>
                                <option value="checking">Checking</option>
                                <option value="in progress">In Progress</option>
                                <option value="done">Done</option>
                                <option value="taken back">Taken Back</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#addRepairModal').on('shown.bs.modal', function() {
                $('.select2-modal').select2({
                    dropdownParent: $('#addRepairModal'),
                    width: '100%'
                });
            });
        });
    </script>
@endpush
