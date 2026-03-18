@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4 p-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                </div>
                <h2 class="fw-bold text-dark mb-3">Pembayaran Berhasil!</h2>
                <p class="text-muted mb-4">Terima kasih, pembayaran untuk tagihan <strong>{{ $invoice->invoice_code }}</strong> telah kami terima. Admin kami akan segera memproses pesanan penyewaan Anda.</p>
                
                <div class="bg-light p-3 rounded-3 mb-4 text-start">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Item:</span>
                        <span class="fw-bold">{{ $invoice->title }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total Bayar:</span>
                        <span class="fw-bold text-success">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <a href="{{ route('chat') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-bold" style="background-color: #0f2f57; border: none;">
                    <i class="fas fa-comments me-2"></i>Kembali ke Chat
                </a>
            </div>
        </div>
    </div>
</div>
@endsection