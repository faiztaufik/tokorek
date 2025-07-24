@extends('admin.layouts.main')

@section('container')
    {{-- Top Metrics: Users, Repairs, Services --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="text-muted small">Total Pengguna</div>
                    <h5 class="mb-0">{{ $totalUsers }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="text-muted small">Customer</div>
                    <h5 class="mb-0">{{ $totalCustomers }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="text-muted small">Teknisi</div>
                    <h5 class="mb-0">{{ $totalTechnicians }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="text-muted small">Total Perbaikan</div>
                    <h5 class="mb-0">{{ $totalRepairs }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Income Section --}}
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body text-center">
                    <div class="text-muted small">Pendapatan Hari Ini</div>
                    <h6 class="text-success mb-0">Rp{{ number_format($dailyIncome, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body text-center">
                    <div class="text-muted small">Pendapatan Minggu Ini</div>
                    <h6 class="text-success mb-0">Rp{{ number_format($weeklyIncome, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body text-center">
                    <div class="text-muted small">Pendapatan Bulan Ini</div>
                    <h6 class="text-success mb-0">Rp{{ number_format($monthlyIncome, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
    </div>

    {{-- Inventory Overview --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="text-muted small">Jumlah Barang</div>
                    <h5 class="mb-0">{{ $totalGoods }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="text-muted small">Kategori</div>
                    <h5 class="mb-0">{{ $totalCategories }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="text-muted small">Barang Masuk</div>
                    <h5 class="text-primary mb-0">{{ $totalGoodIns }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="text-muted small">Barang Keluar</div>
                    <h5 class="text-danger mb-0">{{ $totalGoodOuts }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Other Data --}}
    <div class="row g-3">
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="text-muted small">Jumlah Layanan</div>
                    <h5 class="mb-0">{{ $totalServices }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="text-muted small">Merk Laptop</div>
                    <h5 class="mb-0">{{ $totalBrands }}</h5>
                </div>
            </div>
        </div>
    </div>
@endsection
