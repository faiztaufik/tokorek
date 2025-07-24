@extends('admin.layouts.main')
@section('container')
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#addModal">
                <i class="fa fa-plus"></i>
                Tambah Barang
            </button>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($goods as $good)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $good->name }}</td>
                                <td>{{ $good->category->name }}</td>
                                <td>{{ $good->stock }}</td>
                                <td>{{ $good->description ?? '-' }}</td>
                                <td>
                                    @if ($good->image)
                                        <img src="{{ asset('storage/' . $good->image) }}" alt="Image" width="50">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="d-inline-flex align-items-center">
                                        <button class="btn btn-sm btn-warning mx-1" data-toggle="modal"
                                            data-target="#editModal{{ $good->id }}">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                        <form action="{{ route('admin.goods.delete', $good->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $good->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Barang</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.goods.update', $good->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <input type="text" name="name"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                value="{{ old('name', $good->name) }}" required>
                                                            @error('name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Kategori</label>
                                                            <select name="category_id"
                                                                class="form-control @error('category_id') is-invalid @enderror"
                                                                required>
                                                                @foreach ($categories as $category)
                                                                    <option value="{{ $category->id }}"
                                                                        {{ old('category_id', $good->category_id) == $category->id ? 'selected' : '' }}>
                                                                        {{ $category->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('category_id')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Deskripsi</label>
                                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $good->description) }}</textarea>
                                                            @error('description')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Gambar</label>
                                                            <input type="file" name="image"
                                                                class="form-control-file @error('image') is-invalid @enderror">
                                                            @error('image')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
                                                        <button class="btn btn-primary" type="submit">Simpan</button>
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

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang Baru</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.goods.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror"
                                required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Gambar</label>
                            <input type="file" name="image"
                                class="form-control-file @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
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
@endsection
