@extends('admin.layouts.main')
@section('container')
    <div class="card shadow mb-4">
        <div class="card-body">
            <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#addModal">
                <i class="fa fa-plus"></i>
                Tambah Pengguna
            </button>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td><span class="badge badge-info text-uppercase">{{ $user->role }}</span></td>
                                <td>
                                    <div class="d-inline-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-warning mx-2" data-toggle="modal"
                                            data-target="#editModal{{ $user->id }}">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                        <form action="{{ route('admin.user.delete', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="editModal{{ $user->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Pengguna</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <input type="text" name="name"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                value="{{ old('name', $user->name) }}" required>
                                                            @error('name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" name="email"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                value="{{ old('email', $user->email) }}" required>
                                                            @error('email')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>No HP</label>
                                                            <input type="text" name="phone_number"
                                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                                value="{{ old('phone_number', $user->phone_number) }}"
                                                                required>
                                                            @error('phone_number')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Role</label>
                                                            <select name="role"
                                                                class="form-control @error('role') is-invalid @enderror"
                                                                required>
                                                                <option value="technician"
                                                                    {{ $user->role == 'technician' ? 'selected' : '' }}>
                                                                    Technician</option>
                                                                <option value="admin"
                                                                    {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                                                </option>
                                                            </select>
                                                            @error('role')
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
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengguna Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.user.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>No HP</label>
                            <input type="text" name="phone_number"
                                class="form-control @error('phone_number') is-invalid @enderror"
                                value="{{ old('phone_number') }}" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="technician">Technician</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role')
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
@endsection
