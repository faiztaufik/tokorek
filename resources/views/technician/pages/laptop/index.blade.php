@extends('technician.layouts.main')
@section('container')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#addModal">
                <i class="fa fa-plus"></i>
                Tambah Laptop
            </button>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Laptop</th>
                            <th>Model</th>
                            <th>Merk</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laptops as $laptop)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $laptop->name }}</td>
                                <td>{{ $laptop->model }}</td>
                                <td>{{ $laptop->brand->name }}</td>
                                <td>
                                    <div class="d-inline-flex align-items-center">
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-sm btn-warning mx-2" data-toggle="modal"
                                            data-target="#editModal{{ $laptop->id }}">
                                            <i class="fa fa-pen"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('technician.laptop.delete', $laptop->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus laptop ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $laptop->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $laptop->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('technician.laptop.update', $laptop->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Laptop</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nama Laptop</label>
                                                            <input type="text" name="name"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                value="{{ old('name', $laptop->name) }}" required>
                                                            @error('name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Model</label>
                                                            <input type="text" name="model"
                                                                class="form-control @error('model') is-invalid @enderror"
                                                                value="{{ old('model', $laptop->model) }}" required>
                                                            @error('model')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Merk</label>
                                                            <select name="brand_id"
                                                                class="form-control @error('brand_id') is-invalid @enderror"
                                                                required>
                                                                <option value="">-- Pilih Merk --</option>
                                                                @foreach ($brands as $brand)
                                                                    <option value="{{ $brand->id }}"
                                                                        {{ old('brand_id', $laptop->brand_id) == $brand->id ? 'selected' : '' }}>
                                                                        {{ $brand->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('brand_id')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Ubah</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Edit Modal -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('technician.laptop.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Laptop Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Laptop</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Contoh: MSI GF65 Thin 10UE" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Model</label>
                            <input type="text" name="model" class="form-control @error('model') is-invalid @enderror"
                                value="{{ old('model') }}" placeholder="Contoh: GF65 10UE" required>
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Merk</label>
                            <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Merk --</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Add Modal -->
@endsection
