@extends('admin.layouts.main')
@section('container')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#addModal">
                <i class="fa fa-plus"></i>
                Tambah Merk
            </button>


            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah Laptop</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $brand)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $brand->name }}</td>
                                <td>{{ $brand->laptops->count() }}</td>
                                <td>
                                    <div class="d-inline-flex align-items-center ">
                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-sm btn-warning mx-2" data-toggle="modal"
                                            data-target="#editModal{{ $brand->id }}">
                                            <i class="fa fa-pen"></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.brand.delete', $brand->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus merek ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>


                                    <!-- Modal -->
                                    <div class="modal fade" id="editModal{{ $brand->id }}" tabindex="-1"
                                        aria-labelledby="editModal{{ $brand->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content ">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Merk Baru</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.brand.update', $brand->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body ">
                                                        <div class="form-group">
                                                            <label for="brandName">Nama Merek</label>
                                                            <input type="text"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                id="brandName" name="name"
                                                                value="{{ old('name', $brand->name) }}"
                                                                placeholder="Contoh: Asus" required>

                                                            @error('name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="text-right mt-3">

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

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Merk Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.brand.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="brandName">Nama Merek</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="brandName"
                                name="name" value="{{ old('name') }}" placeholder="Contoh: Asus" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-right mt-3">

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
@endsection
