@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white py-3 text-center" style="background-color: #0f2f57 !important;">
                    <h5 class="mb-0 fw-bold">Pembayaran Online</h5>
                </div>
                <div class="card-body p-5 text-center">
                    
                    <h6 class="text-muted mb-2">Total Tagihan</h6>
                    <h1 class="fw-bold text-primary mb-4">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</h1>
                    
                    <div class="alert alert-light border shadow-sm mb-4 text-start">
                        <strong>{{ $invoice->title }}</strong><br>
                        <span class="text-muted small">Kode: {{ $invoice->invoice_code }}</span>
                    </div>

                    <!-- TOMBOL BAYAR -->
                    @if($invoice->status == 'paid')
                        <div class="alert alert-success">LUNAS</div>
                        <a href="{{ route('chat') }}" class="btn btn-outline-primary">Kembali</a>
                    @else
                        <!-- Cek Token Dulu -->
                        @if($invoice->snap_token)
                            <button id="pay-button" class="btn btn-warning w-100 fw-bold py-3 shadow text-dark fs-5">
                                <i class="fas fa-credit-card me-2"></i> BAYAR SEKARANG
                            </button>
                        @else
                            <div class="alert alert-danger">
                                Token pembayaran gagal dibuat. <br>
                                <small>Silakan hubungi Admin.</small>
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT MIDTRANS -->
<script type="text/javascript" 
        src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('services.midtrans.client_key') }}">
</script>

<script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    
    // Pastikan tombol ada sebelum pasang event listener
    if(payButton) {
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $invoice->snap_token }}', {
                onSuccess: function(result){
                    alert("Pembayaran Berhasil!");
                    window.location.href = "{{ route('chat') }}";
                },
                onPending: function(result){
                    alert("Menunggu pembayaran!");
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                },
                onClose: function(){
                    // do nothing
                }
            });
        });
    }
</script>
@endsection