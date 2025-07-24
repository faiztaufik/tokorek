@extends('general.layouts.main')

@section('container')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                {{-- Alert Success --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{ session('success') }}

                    </div>
                @endif

                {{-- Alert Error --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal!</strong> {{ session('error') }}

                    </div>
                @endif

                {{-- Alert for Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>
                @endif

                <div class="card shadow border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h4 class="mb-0 font-weight-bold text-white">{{ $title }}</h4>
                    </div>

                    <div class="card-body px-4 py-4">
                        <form method="POST" action="{{ route('general.login.post') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="form-group mb-3">
                                <label for="email">Alamat Email</label>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    required placeholder="Email Anda">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="form-group mb-3">
                                <label for="password">Kata Sandi</label>
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required
                                    placeholder="Password Anda">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol Daftar --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block font-weight-bold py-2 col-12">
                                    Login
                                </button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
