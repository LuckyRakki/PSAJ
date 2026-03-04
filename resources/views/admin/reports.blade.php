@extends('layouts.admin')

@section('content')
<style>
    /* Styling khusus untuk mencetak dokumen (Print) */
    @media print {
        body * { visibility: hidden; }
        #print-area, #print-area * { visibility: visible; }
        #print-area { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
        .card { border: none !important; box-shadow: none !important; }
    }
    
    .table-custom th { font-weight: 600; color: #6b7280; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; border-bottom: 2px solid #f3f4f6; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">Laporan Keuangan</h3>
        <p class="text-muted mb-0">Histori transaksi sewa yang sudah berhasil (Lunas).</p>
    </div>
    
    <div class="d-flex align-items-center gap-2">
        <form action="{{ route('admin.reports') }}" method="GET" class="d-flex align-items-center bg-white p-1 rounded-3 shadow-sm border">
            <select name="month" class="form-select form-select-sm border-0 bg-transparent fw-bold text-primary" onchange="this.form.submit()" style="cursor: pointer; outline: none; box-shadow: none;">
                <option value="">-- Semua Bulan --</option>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                        Bulan {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                    </option>
                @endfor
            </select>
        </form>
        
        <button onclick="window.print()" class="btn btn-primary rounded-3 shadow-sm px-3 fw-bold no-print" style="background-color: #0f2f57; border-color: #0f2f57;">
            <i class="fas fa-print me-1"></i> Cetak
        </button>
    </div>
</div>

<div id="print-area">
    <div class="d-none d-print-block mb-4 text-center">
        <h2 class="fw-bold">WIRATAMA TEKNIK</h2>
        <h4>Laporan Keuangan Transaksi Sewa</h4>
        <p>Bulan: {{ request('month') ? date('F', mktime(0, 0, 0, request('month'), 10)) : 'Semua Bulan' }} | Tahun: {{ date('Y') }}</p>
        <hr style="border: 1px solid black;">
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4" style="background-color: #ecfdf5; border-left: 5px solid #10b981 !important;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex justify-content-center align-items-center me-4" style="width: 60px; height: 60px;">
                        <i class="fas fa-wallet fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-bold mb-1 text-uppercase small">Total Pendapatan (Lunas)</h6>
                        <h2 class="fw-bold text-dark mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4" style="background-color: #eff6ff; border-left: 5px solid #3b82f6 !important;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center me-4" style="width: 60px; height: 60px;">
                        <i class="fas fa-clipboard-check fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-bold mb-1 text-uppercase small">Total Transaksi Selesai</h6>
                        <h2 class="fw-bold text-dark mb-0">{{ $invoices->count() }} Transaksi</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">No. Invoice</th>
                            <th class="py-3">Penyewa</th>
                            <th class="py-3">Item Sewa</th>
                            <th class="py-3">Mulai & Durasi</th>
                            <th class="py-3">Tgl Lunas</th>
                            <th class="text-end pe-4 py-3">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $inv)
                        <tr>
                            <td class="ps-4 py-3">
                                <span class="fw-bold text-primary">{{ $inv->invoice_code }}</span>
                            </td>
                            <td class="py-3">
                                <div class="fw-bold text-dark">{{ $inv->nama_penyewa }}</div>
                                <small class="text-muted"><i class="fas fa-phone-alt me-1" style="font-size: 0.7rem;"></i>{{ $inv->no_hp }}</small>
                            </td>
                            <td class="py-3 fw-medium text-dark">{{ $inv->title }}</td>
                            <td class="py-3">
                                <div class="text-dark"><i class="far fa-calendar-alt me-1 text-muted"></i> {{ \Carbon\Carbon::parse($inv->tanggal_mulai)->format('d M Y') }}</div>
                                <span class="badge bg-light text-dark border mt-1">{{ $inv->durasi_sewa }} Hari</span>
                            </td>
                            <td class="py-3 text-muted small">
                                {{ $inv->updated_at->format('d M Y, H:i') }}
                            </td>
                            <td class="text-end pe-4 py-3 fw-bold text-success fs-6">
                                Rp {{ number_format($inv->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-receipt fa-3x mb-3 opacity-25"></i>
                                <p class="mb-0">Belum ada data transaksi lunas di bulan ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection