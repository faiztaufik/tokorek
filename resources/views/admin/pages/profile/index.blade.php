@extends('admin.layouts.main')
@section('container')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Profil Saya</h1>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', auth()->user()->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="phone_number">No. HP</label>
                        <input type="text" name="phone_number" class="form-control"
                            value="{{ old('phone_number', auth()->user()->phone_number) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password Baru (kosongkan jika tidak mengubah)</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui Profil</button>
                </form>
            </div>
        </div>
    </div>
@endsection
