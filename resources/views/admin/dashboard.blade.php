@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold">Dashboard</h3>
    <p class="text-muted">Ringkasan aktivitas penyewaan hari ini.</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-primary text-white" style="background: linear-gradient(45deg, #0f2f57, #1e4b8a);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 text-uppercase small fw-bold">Total Produk</h6>
                        <h2 class="fw-bold mb-0">{{ $totalProducts }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-success text-white" style="background: linear-gradient(45deg, #198754, #20c997);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 text-uppercase small fw-bold">Kategori</h6>
                        <h2 class="fw-bold mb-0">{{ $totalCategories }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-tags fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-warning text-dark" style="background: linear-gradient(45deg, #ffc107, #ffdb4d);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-dark-50 text-uppercase small fw-bold">Pelanggan</h6>
                        <h2 class="fw-bold mb-0">{{ $totalUsers }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TABEL TRANSAKSI TERAKHIR -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold"><i class="fas fa-history me-2"></i>Tagihan Terakhir Dibuat</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Kode</th>
                        <th>Pelanggan</th>
                        <th>Keterangan</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentInvoices as $inv)
                    <tr>
                        <td class="ps-4 fw-bold small">{{ $inv->invoice_code }}</td>
                        <td>{{ $inv->user->name }}</td>
                        <td>{{ $inv->title }}</td>
                        <td>Rp {{ number_format($inv->amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $inv->status == 'paid' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($inv->status) }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $inv->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada tagihan dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection