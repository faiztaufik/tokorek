@extends('admin.layouts.main')
@section('container')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#addModal">
                <i class="fa fa-plus"></i> Tambah Layanan
            </button>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Layanan</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $service->name }}</td>
                                <td>Rp{{ number_format($service->price, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-inline-flex align-items-center">
                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-sm btn-warning mx-2" data-toggle="modal"
                                            data-target="#editModal{{ $service->id }}">
                                            <i class="fa fa-pen"></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.service.delete', $service->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal{{ $service->id }}" tabindex="-1"
                                        aria-labelledby="editModal{{ $service->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.service.update', $service->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Layanan</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="serviceName">Nama Layanan</label>
                                                            <input type="text"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                name="name" value="{{ old('name', $service->name) }}"
                                                                required>
                                                            @error('name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="servicePrice">Harga</label>
                                                            <input type="number"
                                                                class="form-control @error('price') is-invalid @enderror"
                                                                name="price" value="{{ old('price', $service->price) }}"
                                                                required>
                                                            @error('price')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.service.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Layanan Baru</h5>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="serviceName">Nama Layanan</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required placeholder="Contoh: Instalasi Windows">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="servicePrice">Harga</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price') }}" required placeholder="Contoh: 150000">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
