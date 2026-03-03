@extends('layouts.admin')

@section('content')
<!-- Container Utama: Fixed Height agar tidak scroll window -->
<div class="row g-0 rounded shadow-sm overflow-hidden bg-white" style="height: 85vh; border: 1px solid #e0e0e0;">
    
    <!-- KOLOM 1: DAFTAR USER -->
    <div class="col-md-3 border-end d-flex flex-column h-100 d-none d-md-flex">
        <div class="p-3 bg-light border-bottom flex-shrink-0">
            <h6 class="mb-0 fw-bold text-secondary"><i class="fas fa-users me-2"></i>Pelanggan</h6>
        </div>
        <div class="list-group list-group-flush overflow-auto flex-grow-1">
            @foreach($users as $user)
                <a href="{{ route('admin.chat', $user->id) }}" 
                   class="list-group-item list-group-item-action py-3 {{ $currentUser->id == $user->id ? 'active' : '' }}">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" 
                                 style="width: 35px; height: 35px; font-weight: bold; font-size: 0.8rem;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="text-truncate" style="max-width: 120px;">
                                <h6 class="mb-0 small fw-bold {{ $currentUser->id == $user->id ? 'text-white' : 'text-dark' }}">{{ $user->name }}</h6>
                            </div>
                        </div>
                        @if($user->unread > 0)
                            <span class="badge bg-danger rounded-pill">{{ $user->unread }}</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- KOLOM 2: CHAT BOX (Tengah) -->
    <div class="col-md-6 d-flex flex-column border-end bg-light h-100">
        <!-- Header Chat -->
        <div class="p-3 bg-white border-bottom shadow-sm flex-shrink-0 d-flex justify-content-between align-items-center">
            <div class="fw-bold text-primary">
                <i class="fas fa-comment-alt me-2"></i> {{ $currentUser->name }}
            </div>
        </div>

        <!-- Area Pesan (Scrollable) -->
        <div class="flex-grow-1 p-4 overflow-auto" id="chatBox" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
            @foreach($messages as $msg)
                <div class="d-flex mb-3 {{ $msg->sender_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="p-3 rounded-3 shadow-sm" 
                         style="max-width: 75%; 
                                {{ $msg->sender_id == Auth::id() 
                                   ? 'background-color: #0f2f57; color: white; border-bottom-right-radius: 0;' 
                                   : 'background-color: white; color: black; border-bottom-left-radius: 0;' }}">
                        
                        <!-- FIX BOLD TEXT: Gunakan {!! !!} agar HTML render -->
                        <div style="white-space: pre-wrap;">{!! preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', e($msg->message)) !!}</div>
                        
                        <div class="text-end mt-1" style="font-size: 0.65rem; opacity: 0.7;">
                            {{ $msg->created_at->format('H:i') }}
                            @if($msg->sender_id == Auth::id())
                                <i class="fas fa-check-double ms-1 {{ $msg->is_read ? 'text-info' : '' }}"></i>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Footer Input (Sticky Bottom) -->
        <div class="p-3 bg-white border-top flex-shrink-0">
            <form action="{{ route('admin.chat.reply', $currentUser->id) }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="message" class="form-control" placeholder="Tulis balasan..." required autocomplete="off">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>

    <!-- KOLOM 3: FORM INVOICE & APPROVAL (Kanan) -->
    <div class="col-md-3 bg-white p-0 d-flex flex-column h-100">
        <div class="p-3 bg-light border-bottom flex-shrink-0">
            <h6 class="mb-0 fw-bold text-secondary"><i class="fas fa-file-invoice-dollar me-2"></i>Tagihan</h6>
        </div>

        <!-- Form Buat Tagihan -->
        <div class="p-3 border-bottom flex-shrink-0">
            <form action="{{ route('admin.chat.invoice', $currentUser->id) }}" method="POST">
                @csrf
                <div class="mb-2">
                    <label class="small fw-bold">Buat Tagihan Baru</label>
                    <input type="text" name="title" class="form-control form-control-sm mb-1" placeholder="Judul (ex: Sewa Genset)" required>
                    <input type="number" name="amount" class="form-control form-control-sm" placeholder="Harga (ex: 500000)" required>
                </div>
                <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold text-dark">
                    Kirim Tagihan
                </button>
            </form>
        </div>
        
        <!-- List Tagihan (Scrollable) -->
        <div class="flex-grow-1 overflow-auto p-3">
            @php
                $invoices = \App\Models\Invoice::where('user_id', $currentUser->id)->latest()->get();
            @endphp
            @forelse($invoices as $inv)
                <div class="card mb-3 border bg-light shadow-sm">
                    <div class="card-body p-2">
                        <div class="small fw-bold text-truncate">{{ $inv->title }}</div>
                        <div class="d-flex justify-content-between align-items-center mt-1 mb-2">
                            <span class="text-primary small fw-bold">Rp {{ number_format($inv->amount/1000) }}k</span>
                            
                            @if($inv->status == 'pending')
                                <span class="badge bg-secondary" style="font-size: 0.6rem;">Pending</span>
                            @elseif($inv->status == 'confirmed')
                                <span class="badge bg-danger" style="font-size: 0.6rem;">Belum Bayar</span>
                            @elseif($inv->status == 'waiting_verification')
                                <span class="badge bg-warning text-dark blink" style="font-size: 0.6rem;">Cek Bukti</span>
                            @elseif($inv->status == 'paid')
                                <span class="badge bg-success" style="font-size: 0.6rem;">Lunas</span>
                            @endif
                        </div>

                        <!-- TOMBOL AKSI -->
                        
                        <!-- 1. Cek Bukti Bayar (Jika User Upload) -->
                        @if($inv->status == 'waiting_verification')
                            <button type="button" class="btn btn-xs btn-primary w-100 mb-1" data-bs-toggle="modal" data-bs-target="#modalProof-{{$inv->id}}">
                                Lihat Bukti & Konfirmasi
                            </button>
                            
                            <!-- Modal Bukti -->
                            <div class="modal fade" id="modalProof-{{$inv->id}}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title">Konfirmasi Pembayaran</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            
                                            @if($inv->payment_proof)
                                                <div class="mb-3">
                                                    <img src="{{ asset($inv->payment_proof) }}" 
                                                        class="img-fluid rounded border shadow-sm" 
                                                        style="max-height: 450px;"
                                                        alt="Bukti Bayar">
                                                </div>
                                                
                                                <!-- Link Download/Buka Tab Baru jika gambar tidak muncul -->
                                                <div class="mb-3">
                                                    <a href="{{ asset($inv->payment_proof) }}" target="_blank" class="btn btn-xs btn-link">
                                                        <i class="fas fa-external-link-alt"></i> Buka gambar di tab baru
                                                    </a>
                                                </div>
                                            @else
                                                <div class="alert alert-danger">Path gambar kosong di database.</div>
                                            @endif
                                            
                                            <div class="text-start bg-light p-3 rounded small mb-3">
                                                <strong>Penyewa:</strong> {{ $inv->nama_penyewa }}<br>
                                                <strong>Tgl Sewa:</strong> {{ $inv->tanggal_mulai }} ({{ $inv->durasi_sewa }} hari)
                                            </div>
 
                                            <form action="{{ route('admin.invoice.approve', $inv->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                                                    <i class="fas fa-check-circle me-1"></i> Terima & Tandai Lunas
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- 2. APPROVE MANUAL (Jika status Confirmed/Belum Bayar) -->
                        <!-- Berguna jika user bayar cash atau lupa upload bukti -->
                        @if($inv->status == 'confirmed')
                            <form action="{{ route('admin.invoice.approve', $inv->id) }}" method="POST" onsubmit="return confirm('Tandai tagihan ini sebagai LUNAS secara manual?');">
                                @csrf
                                <button type="submit" class="btn btn-xs btn-outline-success w-100 mb-1">
                                    <i class="fas fa-check me-1"></i> Tandai Lunas (Manual)
                                </button>
                            </form>
                        @endif

                        <!-- Detail Data Sewa -->
                        @if($inv->status != 'pending')
                            <button class="btn btn-xs btn-outline-dark w-100" type="button" data-bs-toggle="collapse" data-bs-target="#detail-{{$inv->id}}">
                                Detail Data Sewa
                            </button>
                            <div class="collapse mt-2 small bg-white p-2 border rounded" id="detail-{{$inv->id}}">
                                <strong>Nama:</strong> {{ $inv->nama_penyewa }}<br>
                                <strong>HP:</strong> {{ $inv->no_hp }}<br>
                                <strong>Alamat:</strong> {{ $inv->alamat_pengiriman }}<br>
                                <strong>Tgl:</strong> {{ $inv->tanggal_mulai }}<br>
                                <strong>Durasi:</strong> {{ $inv->durasi_sewa }} hari
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center small text-muted">Belum ada tagihan.</p>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var chatBox = document.getElementById("chatBox");
        if(chatBox) chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>
@endsection