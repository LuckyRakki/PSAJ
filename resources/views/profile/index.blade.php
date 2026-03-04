@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar Profil -->
        <div class="col-md-4 mb-4">
            <div class="card shadow border-0 text-center p-4">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h5 class="fw-bold">{{ $user->name }}</h5>
                <p class="text-muted">{{ $user->email }}</p>
                <hr>
                <div class="text-start">
                    <small class="text-muted">Bergabung sejak:</small>
                    <div class="fw-bold">{{ $user->created_at->format('d M Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Riwayat Transaksi -->
        <div class="col-md-8">
            <h4 class="fw-bold mb-3">Riwayat Penyewaan</h4>
            
            @forelse($invoices as $inv)
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $inv->title }}</h6>
                            <small class="text-muted">{{ $inv->invoice_code }} • {{ $inv->created_at->format('d M Y') }}</small>
                        </div>
                        <span class="badge {{ $inv->status == 'paid' ? 'bg-success' : ($inv->status == 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                            {{ ucfirst($inv->status) }}
                        </span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-bold text-primary">Rp {{ number_format($inv->amount) }}</div>
                        
                        @if($inv->status == 'pending')
                            <!-- Tahap 1: Isi Alamat -->
                            <a href="{{ route('invoice.confirm', $inv->id) }}" class="btn btn-sm btn-warning text-dark">
                                <i class="fas fa-edit"></i> Lengkapi Data
                            </a>

                        @elseif($inv->status == 'confirmed') 
                            <!-- Tahap 2: Bayar (Midtrans) - BUKAN UPLOAD BUKTI -->
                            <a href="{{ route('invoice.payment', $inv->id) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-credit-card"></i> Bayar Sekarang
                            </a>

                        @elseif($inv->status == 'paid')
                            <button class="btn btn-sm btn-secondary" disabled>
                                <i class="fas fa-check-circle"></i> Selesai
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
                <div class="alert alert-light text-center border">Belum ada riwayat penyewaan.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection