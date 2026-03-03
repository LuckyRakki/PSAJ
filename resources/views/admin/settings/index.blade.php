@extends('layouts.admin')

@section('content')
<h3 class="mb-4 fw-bold">Pengaturan Website</h3>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Identitas Web -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold py-3">Identitas Website</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Website</label>
                        <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'Wiratama Teknik' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Logo Website</label>
                        <input type="file" name="site_logo" class="form-control mb-2">
                        @if(!empty($settings['site_logo']))
                            <div class="p-2 border rounded d-inline-block bg-light">
                                <img src="{{ asset($settings['site_logo']) }}" height="50">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekening Pembayaran -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold py-3">Rekening Pembayaran</div>
                <div class="card-body">
                    <div id="bank-wrapper">
                        @php 
                            $banks = json_decode($settings['bank_accounts'] ?? '[]', true); 
                            // Default jika kosong
                            if(empty($banks)) {
                                $banks = [['bank' => '', 'number' => '', 'name' => '']];
                            }
                        @endphp
                        
                        @foreach($banks as $bank)
                        <div class="row g-2 mb-2 bank-item align-items-center">
                            <div class="col-4">
                                <input type="text" name="bank_name[]" class="form-control form-control-sm" placeholder="Nama Bank (BCA)" value="{{ $bank['bank'] }}">
                            </div>
                            <div class="col-4">
                                <input type="text" name="bank_number[]" class="form-control form-control-sm" placeholder="No. Rekening" value="{{ $bank['number'] }}">
                            </div>
                            <div class="col-3">
                                <input type="text" name="bank_account_name[]" class="form-control form-control-sm" placeholder="Atas Nama" value="{{ $bank['name'] }}">
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-bank"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-primary mt-2" id="add-bank">
                        <i class="fas fa-plus me-1"></i> Tambah Rekening
                    </button>
                </div>
            </div>
            <!-- Di dalam form, bagian Identitas Website atau buat card baru -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white fw-bold py-3">Metode Pembayaran (QRIS)</div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label small fw-bold">Upload Gambar QRIS</label>
            <input type="file" name="qris_image" class="form-control mb-2">
            <small class="text-muted d-block mb-2">Upload gambar QR Code dari DANA/OVO/BCA/dll.</small>
            
            @if(!empty($settings['qris_image']))
                <div class="p-2 border rounded d-inline-block bg-light text-center">
                    <img src="{{ asset($settings['qris_image']) }}" style="max-height: 150px;">
                    <br><small class="text-success fw-bold">QRIS Aktif</small>
                </div>
            @endif
        </div>
    </div>
</div>
        </div>
    </div>
    <button type="submit" class="btn btn-success px-4 fw-bold">Simpan Perubahan</button>
</form>

<script>
    document.getElementById('add-bank').addEventListener('click', function() {
        const div = document.createElement('div');
        div.className = 'row g-2 mb-2 bank-item align-items-center';
        div.innerHTML = `
            <div class="col-4"><input type="text" name="bank_name[]" class="form-control form-control-sm" placeholder="Nama Bank"></div>
            <div class="col-4"><input type="text" name="bank_number[]" class="form-control form-control-sm" placeholder="No. Rekening"></div>
            <div class="col-3"><input type="text" name="bank_account_name[]" class="form-control form-control-sm" placeholder="Atas Nama"></div>
            <div class="col-1"><button type="button" class="btn btn-sm btn-outline-danger remove-bank"><i class="fas fa-times"></i></button></div>
        `;
        document.getElementById('bank-wrapper').appendChild(div);
    });

    document.getElementById('bank-wrapper').addEventListener('click', function(e) {
        if (e.target.closest('.remove-bank')) {
            // Jangan hapus jika cuma sisa 1
            if(document.querySelectorAll('.bank-item').length > 1) {
                e.target.closest('.bank-item').remove();
            } else {
                alert("Minimal satu rekening harus ada.");
            }
        }
    });
</script>
@endsection