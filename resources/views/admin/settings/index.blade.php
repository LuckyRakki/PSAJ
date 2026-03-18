@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0 text-dark">Pengaturan Website</h3>
        <p class="text-muted mb-0">Kelola identitas website dan konfigurasi pembayaran otomatis.</p>
    </div>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white fw-bold py-3 border-bottom-0">
                    <i class="fas fa-globe text-primary me-2"></i>Identitas Website
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Website</label>
                        <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'Wiratama Teknik' }}" placeholder="Contoh: Wiratama Teknik">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Logo Website</label>
                        <input type="file" name="site_logo" class="form-control mb-2">
                        @if(!empty($settings['site_logo']))
                            <div class="p-2 border rounded d-inline-block bg-light">
                                <img src="{{ asset($settings['site_logo']) }}" height="40" alt="Logo">
                            </div>
                        @endif
                        <small class="d-block text-muted mt-1">Format: JPG, PNG. Rekomendasi ukuran: tinggi 40px.</small>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white fw-bold py-3 border-bottom-0">
                    <i class="fas fa-headset text-primary me-2"></i>Kontak & Layanan
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="site_phone" class="form-control" value="{{ $settings['site_phone'] ?? '081234567890' }}" placeholder="Contoh: 081234567890">
                        <small class="text-muted d-block mt-1">Nomor ini akan tampil di bagian bawah (footer) website.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Email Perusahaan</label>
                        <input type="email" name="site_email" class="form-control" value="{{ $settings['site_email'] ?? 'info@wiratamateknik.com' }}" placeholder="Contoh: admin@wiratamateknik.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Alamat Toko / Kantor</label>
                        <textarea name="site_address" class="form-control" rows="2" placeholder="Contoh: Jl. Sudirman, Purwokerto">{{ $settings['site_address'] ?? 'Purwokerto, Jawa Tengah' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 h-100" style="background-color: #f8fafc; border: 1px solid #e2e8f0 !important;">
                <div class="card-header bg-transparent fw-bold py-3 border-bottom-0 d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-credit-card text-success me-2"></i>Payment Gateway
                    </div>
                    <span class="badge bg-success rounded-pill px-3">Otomatis Terhubung</span>
                </div>
                <div class="card-body p-4">
                    
                    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center rounded-3 mb-4">
                        <i class="fas fa-check-circle fa-2x me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Midtrans Terintegrasi</h6>
                            <p class="mb-0 small">Pelanggan kini bisa membayar otomatis menggunakan QRIS, Virtual Account (BCA, BNI, dll), dan e-Wallet. Tidak perlu lagi cek mutasi manual!</p>
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Kunci API Midtrans (Opsional)</h6>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Mode Pembayaran (Environment)</label>
                        <select name="midtrans_environment" class="form-select">
                            <option value="sandbox" {{ ($settings['midtrans_environment'] ?? 'sandbox') == 'sandbox' ? 'selected' : '' }}>Sandbox (Mode Pengetesan)</option>
                            <option value="production" {{ ($settings['midtrans_environment'] ?? 'sandbox') == 'production' ? 'selected' : '' }}>Production (Uang Asli)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Client Key</label>
                        <input type="text" name="midtrans_client_key" class="form-control" value="{{ $settings['midtrans_client_key'] ?? '' }}" placeholder="SB-Mid-client-...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Server Key</label>
                        <input type="password" name="midtrans_server_key" class="form-control" value="{{ $settings['midtrans_server_key'] ?? '' }}" placeholder="SB-Mid-server-...">
                    </div>
                    
                    <div class="alert border border-warning bg-white small rounded-3 mt-4 text-muted">
                        <i class="fas fa-info-circle text-warning me-1"></i> 
                        <strong>Catatan:</strong> Jika kunci API di atas dibiarkan kosong, sistem akan otomatis menggunakan kunci bawaan dari file <code>.env</code> server Anda.
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 text-end">
        <button type="submit" class="btn btn-primary px-5 py-3 fw-bold rounded-pill shadow" style="background-color: #0f2f57; border-color: #0f2f57;">
            <i class="fas fa-save me-2"></i> Simpan Pengaturan
        </button>
    </div>
</form>
@endsection