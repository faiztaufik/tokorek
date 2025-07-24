@extends('technician.layouts.main')
@section('container')
    <div class="row">
        <!-- Total Repairs -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white shadow h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Perbaikan</h6>
                        <h3 class="font-weight-bold">{{ $totalRepairs }}</h3>
                    </div>
                    <i class="fas fa-tools fa-2x opacity-75"></i>
                </div>
            </div>
        </div>

        <!-- In Progress -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white shadow h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase mb-1">Sedang Dikerjakan</h6>
                        <h3 class="font-weight-bold">{{ $inProgress }}</h3>
                    </div>
                    <i class="fas fa-spinner fa-2x opacity-75"></i>
                </div>
            </div>
        </div>

        <!-- Done -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white shadow h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase mb-1">Selesai</h6>
                        <h3 class="font-weight-bold">{{ $done }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>

        <!-- Taken Back -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-secondary text-white shadow h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase mb-1">Sudah Diambil</h6>
                        <h3 class="font-weight-bold">{{ $takenBack }}</h3>
                    </div>
                    <i class="fas fa-box-open fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Income -->
    <div class="row">
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card bg-success text-white shadow h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Pendapatan</h6>
                        <h3 class="font-weight-bold">Rp{{ number_format($totalIncome, 0, ',', '.') }}</h3>
                    </div>
                    <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
@endsection
