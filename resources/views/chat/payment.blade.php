@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white py-3 text-center">
                    <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Pembayaran</h5>
                </div>
                <div class="card-body p-4">
                    
                    <!-- TIMER COUNTDOWN -->
                    <div class="text-center mb-4 p-3 bg-light rounded border border-danger">
                        <small class="text-danger fw-bold text-uppercase">Batas Waktu Pembayaran</small>
                        <h3 class="fw-bold mb-0" id="countdown">--:--:--</h3>
                        <small class="text-muted">Segera lakukan pembayaran sebelum waktu habis.</small>
                    </div>

                    <!-- Total Tagihan -->
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</h2>
                        <span class="badge bg-secondary">{{ $invoice->invoice_code }}</span>
                    </div>

                    @php 
                        $qris = \App\Models\Setting::where('key', 'qris_image')->value('value'); 
                    @endphp

                    @if($qris)
                    <div class="text-center mb-4">
                        <div class="card border-primary shadow-sm d-inline-block overflow-hidden">
                            <div class="card-header bg-primary text-white small fw-bold">
                                SCAN QRIS (OVO/GOPAY/DANA/BCA)
                            </div>
                            <div class="card-body p-2 bg-white">
                                <img src="{{ asset($qris) }}" class="img-fluid" style="max-height: 200px;">
                            </div>
                            <div class="card-footer bg-light p-1 small text-muted">
                                A.N Wiratama Teknik
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-3">
                        <span class="text-muted small">- ATAU TRANSFER BANK -</span>
                    </div>
                    @endif

                    <!-- Rekening Dinamis dari Database -->
                    <div class="list-group mb-4 shadow-sm">
                        @php 
                            $banks = json_decode(\App\Models\Setting::where('key', 'bank_accounts')->value('value'), true); 
                        @endphp
                        @foreach($banks as $bank)
                        <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <div class="fw-bold">{{ $bank['bank'] }}</div>
                                <div class="small">{{ $bank['name'] }}</div>
                            </div>
                            <span class="fw-bold font-monospace fs-5">{{ $bank['number'] }}</span>
                        </div>
                        @endforeach
                    </div>

                    <!-- Form Upload -->
                    <form action="{{ route('invoice.payment.process', $invoice->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload Bukti Transfer</label>
                            <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success fw-bold py-2">Kirim Bukti Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bagian Script Timer -->
<script>
    // Ambil timestamp dari PHP (detik * 1000 untuk jadi milidetik)
    // Jika due_date null, set default 24 jam dari created_at
    var countDownDate = {{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->timestamp * 1000 : \Carbon\Carbon::parse($invoice->created_at)->addDay()->timestamp * 1000 }};

    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;

        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Tambahkan leading zero (09:05:01)
        hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        document.getElementById("countdown").innerHTML = hours + " : " + minutes + " : " + seconds;

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdown").innerHTML = "WAKTU HABIS";
            document.getElementById("countdown").classList.add("text-danger");
        }
    }, 1000);
</script>
@endsection