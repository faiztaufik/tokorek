@extends('admin.layouts.main')
@section('container')
    <div class="card shadow mb-4">
        <div class="card-body">

            <form method="GET" action="{{ route('admin.goodouts.index') }}" class="mb-4">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-filter me-1"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.goodouts.export.pdf', request()->only('start_date', 'end_date')) }}"
                            class="btn btn-danger w-100">
                            <i class="fa fa-file-pdf me-1"></i> Export PDF
                        </a>
                    </div>
                </div>
            </form>


            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#addModal">
                <i class="fa fa-plus"></i> Tambah Barang Keluar
            </button>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Tanggal Keluar</th>
                            <th>Catatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($goodsOut as $out)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $out->good->name }}</td>
                                <td>{{ $out->quantity }}</td>
                                <td>{{ \Carbon\Carbon::parse($out->date_out)->format('d M Y') }}</td>
                                <td>{{ $out->note ?? '-' }}</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.goodouts.destroy', $out->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.goodouts.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Barang Keluar</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <select name="good_id" class="form-control" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($goods as $good)
                                    <option value="{{ $good->id }}">{{ $good->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" name="quantity" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Keluar</label>
                            <input type="date" name="date_out" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Catatan</label>
                            <input type="text" name="note" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
