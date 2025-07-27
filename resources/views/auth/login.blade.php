@extends('layouts.guest')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg border-0" style="width: 400px; background: #222;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <a href="{{ url('/') }}" class="fw-bold fs-3 text-decoration-none" style="color: #0d6efd;">
                    BarangGratis.com
                </a>
                <h5 class="mt-2 mb-4 text-white-50">Masuk Akun</h5>
            </div>
            @if (session('status'))
                <div class="alert alert-success small">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label text-white">Email</label>
                    <input type="email" name="email" class="form-control bg-dark text-light @error('email') is-invalid @enderror" required autofocus value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-white">Password</label>
                    <input type="password" name="password" class="form-control bg-dark text-light @error('password') is-invalid @enderror" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label class="form-check-label text-white-50" for="remember">Ingat Saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none small" style="color:#0d6efd;">Lupa password?</a>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Masuk</button>
            </form>
            <div class="mt-4 text-center small">
                <span class="text-white-50">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="text-decoration-none" style="color:#0d6efd;">Daftar gratis</a>
            </div>
        </div>
    </div>
</div>
@endsection

