@extends('layouts.app')

@section('content')
<div class="container py-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-plus fa-3x mb-3" style="color: #0f2f57;"></i>
                        <h3 class="fw-bold" style="color: #0f2f57;">Buat Akun</h3>
                        <p class="text-muted small">Daftar untuk mulai menyewa alat teknik</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control bg-light border-0" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control bg-light border-0" placeholder="email@contoh.com" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Password</label>
                                <input type="password" name="password" class="form-control bg-light border-0" placeholder="••••••••" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold">Konfirmasi</label>
                                <input type="password" name="password_confirmation" class="form-control bg-light border-0" placeholder="••••••••" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold py-2 shadow-sm" style="color: #0f2f57;">
                            DAFTAR SEKARANG
                        </button>
                    </form>
                    <div class="text-center mt-4">
                        <p class="small text-muted mb-0">Sudah punya akun?</p>
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #0f2f57;">Masuk Disini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection