@extends('layouts.app')

@section('content')
<style>
    .avatar-circle {
        width: 100px;
        height: 100px;
        font-size: 2.5rem;
        background: linear-gradient(135deg, #0f2f57, #1e4b8a);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 20px auto;
        box-shadow: 0 5px 15px rgba(15, 47, 87, 0.2);
    }
    .history-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border-left: 4px solid #dee2e6 !important;
    }
    .history-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }
    .status-pending { border-left-color: #ffc107 !important; }
    .status-unpaid { border-left-color: #dc3545 !important; }
    .status-paid { border-left-color: #198754 !important; }
</style>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-4 rounded-4 position-sticky" style="top: 20px;">
                <div class="avatar-circle fw-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h4 class="fw-bold text-dark mb-1">Halo, {{ $user->name }}!</h4>
                <p class="text-muted mb-4">{{ $user->email }}</p>
                
                <div class="bg-light p-3 rounded-3 text-start">
                    <div class="d-flex align-items-center text-muted small mb-2">
                        <i class="fas fa-calendar-alt me-2 text-primary"></i> Bergabung sejak
                    </div>
                    <div class="fw-bold text-dark">{{ $user->created_at->format('d M Y') }}</div>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 rounded-pill fw-bold">
                        <i class="fas fa-sign-out-alt me-2"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <h4 class="fw-bold mb-4 text-dark"><i class="fas fa-history text-primary me-2"></i>Riwayat Penyewaan</h4>
            
            @forelse($invoices as $inv)
                @php
                    // Tentukan warna border kiri berdasarkan status
                    $borderClass = 'status-pending'; // default (Isi Data)
                    if($inv->status == 'confirmed' || $inv->status == 'waiting_verification') $borderClass = 'status-unpaid';
                    if($inv->status == 'paid') $borderClass = 'status-paid';
                @endphp

                <div class="card history-card shadow-sm border-0 mb-3 rounded-4 {{ $borderClass }}">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{{ $inv->title }}</h6>
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fas fa-receipt me-1"></i> {{ $inv->invoice_code }} 
                                    <span class="mx-2">•</span> 
                                    <i class="far fa-clock me-1"></i> {{ $inv->created_at->format('d M Y') }}
                                </small>
                            </div>
                            
                            @if($inv->status == 'pending')
                                <span class="badge rounded-pill bg-warning text-dark px-3 py-2"><i class="fas fa-edit me-1"></i> Pending</span>
                            @elseif($inv->status == 'confirmed' || $inv->status == 'waiting_verification')
                                <span class="badge rounded-pill bg-danger px-3 py-2"><i class="fas fa-exclamation-circle me-1"></i> Belum Bayar</span>
                            @elseif($inv->status == 'paid')
                                <span class="badge rounded-pill bg-success px-3 py-2"><i class="fas fa-check-circle me-1"></i> Lunas</span>
                            @endif
                        </div>
                        
                        <hr class="text-muted opacity-25">
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block">Total Tagihan</small>
                                <div class="fw-bold text-dark fs-5">Rp {{ number_format($inv->amount, 0, ',', '.') }}</div>
                            </div>
                            
                            <div>
                                @if($inv->status == 'pending')
                                    <a href="{{ route('invoice.confirm', $inv->id) }}" class="btn btn-warning text-dark fw-bold rounded-pill px-4">
                                        Lengkapi Data <i class="fas fa-arrow-right ms-1"></i>
                                    </a>

                                @elseif($inv->status == 'confirmed' || $inv->status == 'waiting_verification') 
                                    <a href="{{ route('invoice.payment', $inv->id) }}" class="btn btn-danger fw-bold rounded-pill px-4">
                                        Bayar Sekarang <i class="fas fa-credit-card ms-1"></i>
                                    </a>

                                @elseif($inv->status == 'paid')
                                    <button class="btn btn-light text-success fw-bold rounded-pill px-4 border" disabled>
                                        <i class="fas fa-check"></i> Selesai
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card border-0 shadow-sm rounded-4 py-5 text-center">
                    <div class="card-body">
                        <i class="fas fa-box-open fa-4x text-muted opacity-25 mb-3"></i>
                        <h5 class="fw-bold text-dark">Belum ada riwayat sewa</h5>
                        <p class="text-muted mb-4">Yuk, mulai eksplorasi katalog produk kami dan buat pesanan pertamamu!</p>
                        <a href="{{ route('products') }}" class="btn btn-primary rounded-pill px-4 fw-bold" style="background-color: #0f2f57; border: none;">
                            Lihat Katalog Produk
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection