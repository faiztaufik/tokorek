@extends('general.layouts.main')

@section('container')
    <style>
        .custom-login-button {
        background-color: #0c6eeeff; /* warna tombol */
        color: #fff;
        border: none;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-login-button:hover {
            background-color: #287be9ff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
        }

        .custom-login-button:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.5);
        }
        body {
            background-color: #ffffff;
        }

        .login-card {
            animation: fadeIn 0.5s ease-in-out;
            border-radius: 1rem;
            overflow: hidden;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .form-group {
        position: relative;
        }

        .form-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
        }

        .form-icon {
            position: absolute;
            top: 43px;
            left: 15px;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .form-control {
            padding-left: 2.5rem;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center align-items-center min-vh-100">
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

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0">
                            Anda bukan admin atau teknisi
                        </ul>
                    </div>
                @endif

                <div class="card shadow login-card">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h4 class="mb-0 font-weight-bold">{{ $title }}</h4>
                    </div>

                    <div class="card-body px-4 py-4 bg-light">
                        <form method="POST" action="{{ route('general.login.post') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="form-group mb-4 position-relative">
                                <label for="email">Alamat Email</label>
                                <i class="fa fa-envelope form-icon"></i>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required placeholder="Masukkan email anda">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="form-group mb-4 position-relative">
                                <label for="password">Kata Sandi</label>
                                <i class="fa fa-lock form-icon"></i>
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required
                                    placeholder="Masukkan kata sandi">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol Login --}}
                            <div class="form-group mb-0">
                                <button type="submit" class="btn custom-login-button btn-block font-weight-bold py-2 w-100">
                                    <i class="fa fa-sign-in-alt me-2"></i> Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
