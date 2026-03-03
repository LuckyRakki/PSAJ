@extends('layouts.app')

@section('content')
<style>
    .chat-box::-webkit-scrollbar { width: 6px; }
    .chat-box::-webkit-scrollbar-track { background: #f1f1f1; }
    .chat-box::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
    
    .message-bubble {
        max-width: 80%; /* Diperlebar */
        padding: 12px 18px;
        border-radius: 15px;
        position: relative;
        font-size: 1rem;
        line-height: 1.5;
    }
    .message-sent { background-color: #0f2f57; color: white; border-bottom-right-radius: 2px; }
    .message-received { background-color: white; color: #333; border-bottom-left-radius: 2px; border: 1px solid #e0e0e0; }
    
    .message-time {
        font-size: 0.7rem;
        margin-top: 5px;
        display: block;
        opacity: 0.7;
        text-align: right;
    }
    .fa-check-double.read { color: #4fc3f7; }
</style>

<div class="container py-4"> <!-- Padding dikurangi agar lebih full -->
    <div class="row justify-content-center">
        
        <!-- KOLOM KIRI: STATUS TAGIHAN (Lebar disesuaikan) -->
        @if(isset($invoices) && $invoices->count() > 0)
        <div class="col-lg-3 mb-3">
            <div class="card shadow border-0">
                <div class="card-header bg-warning text-dark fw-bold">
                    <i class="fas fa-file-invoice-dollar me-2"></i> Tagihan
                </div>
                <div class="card-body bg-light p-2" style="max-height: 600px; overflow-y: auto;">
                    @foreach($invoices as $inv)
                        
                        <!-- 1. PENDING: Belum isi data -->
                        @if($inv->status == 'pending')
                            <div class="p-3 bg-white border-start border-4 border-warning shadow-sm mb-2 rounded">
                                <div class="fw-bold text-dark">{{ $inv->title }}</div>
                                <div class="text-primary fw-bold mt-1">Rp {{ number_format($inv->amount) }}</div>
                                <a href="{{ route('invoice.confirm', $inv->id) }}" class="btn btn-sm btn-primary w-100 mt-2">
                                    <i class="fas fa-edit me-1"></i> Isi Data Sewa
                                </a>
                            </div>

                        <!-- 2. CONFIRMED: Sudah isi data, TAPI BELUM BAYAR -->
                        @elseif($inv->status == 'confirmed')
                            <div class="p-3 bg-white border-start border-4 border-danger shadow-sm mb-2 rounded">
                                <div class="fw-bold text-dark">{{ $inv->title }}</div>
                                <div class="badge bg-danger text-white mb-2">Belum Dibayar</div>
                                <small class="d-block text-muted mb-2">Data sewa tersimpan. Silakan upload bukti bayar.</small>
                                <a href="{{ route('invoice.payment', $inv->id) }}" class="btn btn-sm btn-danger w-100">
                                    <i class="fas fa-upload me-1"></i> Bayar Sekarang
                                </a>
                            </div>

                        <!-- 3. WAITING VERIFICATION: Sudah upload, nunggu admin -->
                        @elseif($inv->status == 'waiting_verification')
                            <div class="p-3 bg-white border-start border-4 border-info shadow-sm mb-2 rounded">
                                <div class="fw-bold text-dark">{{ $inv->title }}</div>
                                <div class="badge bg-info text-dark mb-1">Menunggu Konfirmasi Admin</div>
                                <small class="d-block text-muted">Bukti bayar sedang dicek.</small>
                            </div>

                        <!-- 4. PAID: Lunas -->
                        @elseif($inv->status == 'paid')
                            <div class="p-3 bg-white border-start border-4 border-success shadow-sm mb-2 rounded opacity-75">
                                <div class="fw-bold text-dark">{{ $inv->title }}</div>
                                <div class="badge bg-success mb-1">Lunas / Selesai</div>
                            </div>
                        @endif

                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- KOLOM KANAN: CHAT BOX (Diperbesar) -->
        <div class="{{ (isset($invoices) && $invoices->count() > 0) ? 'col-lg-9' : 'col-lg-10' }}">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header text-white py-3 d-flex justify-content-between align-items-center" style="background-color: #0f2f57;">
                    <div class="d-flex align-items-center">
                        <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                            <i class="fas fa-headset fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold fs-5">Admin Wiratama</h6>
                            <small class="text-warning"><i class="fas fa-circle fa-xs me-1"></i>Online</small>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="text-white"><i class="fas fa-times fa-lg"></i></a>
                </div>

                <div class="card-body chat-box bg-light" id="chatContainer" style="height: 65vh; overflow-y: auto; background-image: url('https://www.transparenttextures.com/patterns/subtle-grey.png');">
                    @forelse($messages as $msg)
                        <div class="d-flex mb-3 {{ $msg->sender_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="message-bubble {{ $msg->sender_id == Auth::id() ? 'message-sent' : 'message-received' }} shadow-sm">
                                <!-- PARSING BOLD TEXT -->
                                {!! preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', e($msg->message)) !!}
                                
                                <span class="message-time">
                                    {{ $msg->created_at->format('H:i') }} 
                                    @if($msg->sender_id == Auth::id())
                                        <i class="fas fa-check-double ms-1 {{ $msg->is_read ? 'read' : '' }}"></i>
                                    @endif
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center mt-5 text-muted">
                            <i class="fas fa-comments fa-4x mb-3 opacity-25"></i>
                            <p>Halo! Ada yang bisa kami bantu?</p>
                        </div>
                    @endforelse
                </div>

                <div class="card-footer bg-white p-3 border-top">
                    <form action="{{ route('chat.send') }}" method="POST">
                        @csrf
                        <div class="input-group input-group-lg">
                            <input type="text" name="message" class="form-control border-0 bg-light rounded-start-pill ps-4" placeholder="Ketik pesan..." required autofocus autocomplete="off">
                            <button class="btn btn-primary rounded-end-pill px-4" type="submit" style="background-color: #0f2f57;">
                                <i class="fas fa-paper-plane"></i>
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
        var chatBox = document.getElementById("chatContainer");
        if(chatBox) chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>
@endsection