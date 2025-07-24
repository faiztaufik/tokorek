@extends('admin.layouts.main')
@section('container')
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="mb-4">Detail & Edit Data Perbaikan</h5>

            <form action="{{ route('admin.repair.update', $repair->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="receipt_code">Kode Nota</label>
                    <input type="text" class="form-control" value="{{ $repair->receipt_code }}" readonly>
                </div>

                <div class="form-group">
                    <label for="customer_name">Nama Customer</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ $repair->customer_name }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="customer_phone_number">No. Telepon Customer</label>
                    <input type="text" name="customer_phone_number" class="form-control"
                        value="{{ $repair->customer_phone_number }}" required>
                </div>


                <div class="form-group">
                    <label for="date_in">Tanggal Masuk</label>
                    <input type="date" name="date_in" class="form-control" value="{{ $repair->date_in }}" readonly>
                </div>

                <div class="form-group">
                    <label for="date_taken_back">Tanggal Diambil</label>
                    <input type="date" name="date_taken_back" class="form-control"
                        value="{{ $repair->date_taken_back }}">
                </div>

                <div class="form-group">
                    <label for="technician_id">Teknisi</label>
                    <select name="technician_id" class="form-control select2" required>
                        @foreach ($technicians as $technician)
                            <option value="{{ $technician->id }}"
                                {{ $repair->technician_id == $technician->id ? 'selected' : '' }}>
                                {{ $technician->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label for="laptop_id">Laptop</label>
                    <select name="laptop_id" class="form-control select2" required>
                        @foreach ($laptops as $laptop)
                            <option value="{{ $laptop->id }}" {{ $repair->laptop_id == $laptop->id ? 'selected' : '' }}>
                                {{ $laptop->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="customer_complaint">Keluhan Customer</label>
                    <textarea name="customer_complaint" class="form-control" rows="3">{{ $repair->customer_complaint }}</textarea>
                </div>

                <div class="form-group">
                    <label for="problem">Diagnosa Teknisi</label>
                    <textarea name="problem" class="form-control" rows="3">{{ $repair->problem }}</textarea>
                </div>

                <div class="form-group">
                    <label for="service_state">Status Perbaikan</label>
                    <select name="service_state" class="form-control">
                        @foreach (['checking', 'in progress', 'done', 'taken back'] as $status)
                            <option value="{{ $status }}"
                                {{ $repair->service_state === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="services">Layanan Dikerjakan</label>
                    <div class="row">
                        @foreach ($services as $service)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="services[]"
                                        value="{{ $service->id }}" id="service_{{ $service->id }}"
                                        {{ in_array($service->id, old('services', $repair->services->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="service_{{ $service->id }}">
                                        {{ $service->name }} (Rp{{ number_format($service->price, 0, ',', '.') }})
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <div class="form-group">
                    <label for="total_price">Total Biaya</label>
                    <input type="text" class="form-control"
                        value="Rp{{ number_format($repair->total_price, 0, ',', '.') }}" readonly>
                </div>



                <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });
        });
    </script>
@endpush
