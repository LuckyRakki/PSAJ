@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5">
            <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header border-0 text-center py-4" style="background-color: #0f2f57;">
                    <h4 class="mb-0 fw-bold text-white"><i class="fas fa-user-plus me-2"></i>Daftar Akun</h4>
                </div>
                <div class="card-body p-5">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control bg-light" placeholder="Masukkan nama sesuai KTP" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control bg-light" placeholder="email@contoh.com" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Password</label>
                                <input type="password" name="password" class="form-control bg-light" placeholder="******" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Konfirmasi</label>
                                <input type="password" name="password_confirmation" class="form-control bg-light" placeholder="******" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold py-2 shadow-sm text-dark mt-2">
                            BUAT AKUN BARU <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                    </form>
                    <div class="text-center mt-4">
                        <p class="small text-muted mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #0f2f57;">Login Disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection