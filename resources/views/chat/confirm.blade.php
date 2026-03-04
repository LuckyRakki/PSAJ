@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white py-3" style="background-color: #0f2f57 !important;">
                    <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Konfirmasi Sewa</h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert border shadow-sm mb-4" style="background-color: #f8f9fa;">
                        <h6 class="fw-bold text-primary"><i class="fas fa-info-circle me-2"></i>Detail Pesanan</h6>
                        <hr>
                        <p class="mb-1">Item: <strong>{{ $invoice->title }}</strong></p>
                        <p class="mb-0">
                            Total Biaya: 
                            <strong class="text-danger fs-5" id="display-total">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</strong>
                            <span class="text-muted small">/ <span id="display-hari">1</span> Hari</span>
                        </p>
                    </div>

                    <form action="{{ route('invoice.process', $invoice->id) }}" method="POST">
                        @csrf
                        <h6 class="fw-bold border-bottom pb-2 mb-3">Data Penyewa & Pengiriman</h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Penyewa</label>
                                <input type="text" name="nama_penyewa" class="form-control" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor WhatsApp / HP</label>
                                <input type="text" name="no_hp" class="form-control" placeholder="0812..." required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap Pengiriman</label>
                            <textarea name="alamat_pengiriman" class="form-control" rows="3" placeholder="Nama jalan, nomor rumah, patokan..." required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Mulai Sewa</label>
                                <input type="date" name="tanggal_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Durasi Sewa (Hari)</label>
                                <input type="number" name="durasi_sewa" id="input-durasi" class="form-control fw-bold" value="1" min="1" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Catatan Tambahan (Opsional)</label>
                            <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Tolong antar jam 8 pagi"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('chat') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning fw-bold px-4">
                                <i class="fas fa-paper-plane me-2"></i> Konfirmasi & Lanjut Bayar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil harga dasar dari database (harga per hari)
        const basePrice = {{ $invoice->amount }};
        
        const inputDurasi = document.getElementById('input-durasi');
        const displayTotal = document.getElementById('display-total');
        const displayHari = document.getElementById('display-hari');

        inputDurasi.addEventListener('input', function() {
            let durasi = parseInt(this.value) || 1;
            
            // Mencegah input hari minus atau 0
            if(durasi < 1) durasi = 1;

            // Hitung total harga
            let total = basePrice * durasi;

            // Ubah format ke Rupiah secara otomatis (misal: 1500000 -> 1.500.000)
            let formattedTotal = new Intl.NumberFormat('id-ID').format(total);
            
            displayTotal.innerHTML = 'Rp ' + formattedTotal;
            displayHari.innerHTML = durasi;
        });
    });
</script>
@endsection