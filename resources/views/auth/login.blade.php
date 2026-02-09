@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-tools fa-3x mb-3" style="color: #0f2f57;"></i>
                        <h3 class="fw-bold" style="color: #0f2f57;">Masuk Akun</h3>
                        <p class="text-muted small">Silakan masuk ke akun Wiratama Teknik Anda</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-0" placeholder="nama@email.com" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-0" placeholder="••••••••" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold py-2 shadow-sm" style="color: #0f2f57;">
                            LOGIN <i class="fas fa-sign-in-alt ms-1"></i>
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="small text-muted mb-0">Belum punya akun?</p>
                        <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #0f2f57;">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection