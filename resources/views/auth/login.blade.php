@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-5">
            <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header border-0 text-center py-4" style="background-color: #0f2f57;">
                    <h4 class="mb-0 fw-bold text-white"><i class="fas fa-lock me-2"></i>Login Member</h4>
                </div>
                <div class="card-body p-5">
                    @if($errors->any())
                        <div class="alert alert-danger border-0 small">
                            <i class="fas fa-exclamation-circle me-1"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 bg-light" placeholder="email@contoh.com" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-muted"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 bg-light" placeholder="******" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold py-2 shadow-sm text-dark">
                            MASUK SEKARANG <i class="fas fa-sign-in-alt ms-1"></i>
                        </button>
                    </form>
                    <div class="text-center mt-4">
                        <p class="small text-muted mb-0">Belum punya akun? <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #0f2f57;">Daftar Disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection