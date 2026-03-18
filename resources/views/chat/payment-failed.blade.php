@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4 p-5">
                <div class="mb-4">
                    <i class="fas fa-times-circle text-danger" style="font-size: 80px;"></i>
                </div>
                <h2 class="fw-bold text-dark mb-3">Pembayaran Tertunda / Gagal</h2>
                <p class="text-muted mb-4">Mohon maaf, sepertinya Anda membatalkan pembayaran atau terjadi kesalahan pada sistem bank. Silakan coba kembali.</p>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('invoice.payment', $invoice->id) }}" class="btn btn-warning px-4 py-2 rounded-pill fw-bold text-dark">
                        <i class="fas fa-redo me-2"></i> Coba Bayar Lagi
                    </a>
                    <a href="{{ route('chat') }}" class="btn btn-light px-4 py-2 rounded-pill fw-bold text-secondary border">
                        Kembali ke Chat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection