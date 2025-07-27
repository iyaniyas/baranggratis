@extends('layouts.guest')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg border-0" style="width: 400px; background: #222;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <a href="{{ url('/') }}" class="fw-bold fs-3 text-decoration-none" style="color: #0d6efd;">
                    BarangGratis.com
                </a>
                <h5 class="mt-2 mb-4 text-white-50">Daftar Akun Baru</h5>
            </div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label text-white">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control bg-dark text-light @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-white">Email</label>
                    <input type="email" name="email" class="form-control bg-dark text-light @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-white">Password</label>
                    <input type="password" name="password" class="form-control bg-dark text-light @error('password') is-invalid @enderror" required autocomplete="new-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label text-white">Ulangi Password</label>
                    <input type="password" name="password_confirmation" class="form-control bg-dark text-light" required autocomplete="new-password">
                </div>
                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Daftar</button>
            </form>
            <div class="mt-4 text-center small">
                <span class="text-white-50">Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="text-decoration-none" style="color:#0d6efd;">Masuk</a>
            </div>
        </div>
    </div>
</div>
@endsection

