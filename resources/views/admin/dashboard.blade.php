@extends('layouts.admin')

@section('content')
<style>
    /* Animasi mengambang untuk Card */
    .card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    
    /* Styling tabel transparan & modern */
    .table-custom th { font-weight: 600; color: #6b7280; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; border-bottom: 2px solid #f3f4f6; padding-top: 1rem; padding-bottom: 1rem; }
    .table-custom td { padding-top: 1rem; padding-bottom: 1rem; vertical-align: middle; color: #374151; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">Dashboard Overview</h3>
        <p class="text-muted mb-0">Selamat datang kembali, pantau ringkasan aktivitas penyewaanmu di sini.</p>
    </div>
    <div class="text-end d-none d-md-block">
        <span class="text-muted small"><i class="fas fa-calendar-alt me-1"></i> {{ date('d F Y') }}</span>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 card-hover rounded-4" style="background: linear-gradient(135deg, #0f2f57 0%, #1e4b8a 100%);">
            <div class="card-body p-4 position-relative overflow-hidden">
                <i class="fas fa-box position-absolute" style="font-size: 6rem; opacity: 0.1; right: -10px; bottom: -15px; color: white;"></i>
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="bg-white bg-opacity-25 rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fas fa-box text-white fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-white">{{ $totalProducts }}</h3>
                <h6 class="text-white-50 small mt-1">Total Produk Aktif</h6>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 card-hover rounded-4" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="card-body p-4 position-relative overflow-hidden">
                <i class="fas fa-tags position-absolute" style="font-size: 6rem; opacity: 0.1; right: -10px; bottom: -15px; color: white;"></i>
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="bg-white bg-opacity-25 rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fas fa-tags text-white fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-white">{{ $totalCategories }}</h3>
                <h6 class="text-white-50 small mt-1">Kategori Tersedia</h6>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 card-hover rounded-4" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <div class="card-body p-4 position-relative overflow-hidden">
                <i class="fas fa-users position-absolute" style="font-size: 6rem; opacity: 0.1; right: -10px; bottom: -15px; color: white;"></i>
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="bg-white bg-opacity-25 rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fas fa-users text-white fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-white">{{ $totalUsers }}</h3>
                <h6 class="text-white-50 small mt-1">Total Pelanggan Terdaftar</h6>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white py-4 d-flex justify-content-between align-items-center border-bottom-0">
        <h6 class="mb-0 fw-bold fs-5 text-dark"><i class="fas fa-history text-primary me-2"></i>Transaksi & Tagihan Terakhir</h6>
        <a href="{{ route('admin.chat') }}" class="btn btn-sm btn-light text-primary fw-bold">Lihat Semua di Chat</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">No. Tagihan</th>
                        <th>Pelanggan</th>
                        <th>Detail Item</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentInvoices as $inv)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold text-dark">{{ $inv->invoice_code }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 35px; height: 35px; font-weight: bold;">
                                    {{ substr($inv->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">{{ $inv->user->name }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark fw-medium" style="font-size: 0.9rem;">{{ $inv->title }}</div>
                        </td>
                        <td>
                            <span class="fw-bold text-success">Rp {{ number_format($inv->amount, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            @if($inv->status == 'paid')
                                <span class="badge rounded-pill bg-success px-3 py-2"><i class="fas fa-check-circle me-1"></i> Lunas</span>
                            @elseif($inv->status == 'pending')
                                <span class="badge rounded-pill bg-secondary px-3 py-2"><i class="fas fa-clock me-1"></i> Pending</span>
                            @else
                                <span class="badge rounded-pill bg-danger px-3 py-2"><i class="fas fa-exclamation-circle me-1"></i> Belum Bayar</span>
                            @endif
                        </td>
                        <td class="text-end pe-4 small text-muted">
                            {{ $inv->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                            <p class="mb-0">Belum ada tagihan yang dibuat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection