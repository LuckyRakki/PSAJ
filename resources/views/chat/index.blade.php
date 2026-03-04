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
                        
                        @if($inv->status == 'pending')
                            <div class="p-3 bg-white border-start border-4 border-warning shadow-sm mb-2 rounded">
                                <div class="fw-bold text-dark">{{ $inv->title }}</div>
                                <div class="text-primary fw-bold mt-1">Rp {{ number_format($inv->amount, 0, ',', '.') }}</div>
                                <a href="{{ route('invoice.confirm', $inv->id) }}" class="btn btn-sm btn-primary w-100 mt-2">
                                    <i class="fas fa-edit me-1"></i> Isi Data Sewa
                                </a>
                            </div>

                        @elseif($inv->status == 'confirmed' || $inv->status == 'waiting_verification')
                            <div class="p-3 bg-white border-start border-4 border-danger shadow-sm mb-2 rounded">
                                <div class="fw-bold text-dark">{{ $inv->title }}</div>
                                <div class="badge bg-danger text-white mb-2">Belum Dibayar</div>
                                <small class="d-block text-muted mb-2">Batas waktu pembayaran 24 jam dari tagihan dibuat.</small>
                                <a href="{{ route('invoice.payment', $inv->id) }}" class="btn btn-sm btn-danger w-100 fw-bold">
                                    <i class="fas fa-credit-card me-1"></i> Bayar Sekarang
                                </a>
                            </div>

                        @elseif($inv->status == 'paid')
                            <div class="p-3 bg-white border-start border-4 border-success shadow-sm mb-2 rounded opacity-75">
                                <div class="fw-bold text-dark">{{ $inv->title }}</div>
                                <div class="badge bg-success mb-1">Lunas / Selesai</div>
                                <small class="d-block text-muted">Barang akan segera diproses.</small>
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
                    @foreach($messages as $msg)
                        <div class="d-flex mb-3 {{ $msg->sender_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                            
                            @if(strpos($msg->message, '[PRODUCT_CARD]|') === 0)
                                @php 
                                    $parts = explode('|', $msg->message); 
                                    $pId = $parts[1] ?? ''; $pName = $parts[2] ?? ''; $pCat = $parts[3] ?? ''; $pImg = $parts[4] ?? '';
                                @endphp
                                <div class="card border-0 shadow-sm rounded-4" style="width: 240px; overflow: hidden; background: #fff;">
                                    <div class="bg-light d-flex align-items-center justify-content-center p-2" style="height: 130px;">
                                        <img src="{{ asset($pImg) }}" style="max-height: 110px; max-width: 100%; object-fit: contain;" alt="Produk">
                                    </div>
                                    <div class="card-body p-3 border-top">
                                        <h6 class="mb-1 fw-bold text-dark text-truncate" style="font-size: 0.9rem;">{{ $pName }}</h6>
                                        <small class="text-muted d-block mb-3 text-truncate" style="font-size: 0.75rem;"><i class="fas fa-tag me-1"></i> {{ $pCat }}</small>
                                        <a href="{{ route('product.detail', $pId) }}" class="btn btn-sm btn-outline-warning w-100 fw-bold rounded-pill text-dark" style="font-size: 0.8rem;">
                                            <i class="fas fa-eye me-1"></i> Lihat Produk
                                        </a>
                                    </div>
                                    <div class="card-footer bg-white border-0 py-1 text-end" style="font-size: 0.65rem; color: #aaa;">
                                        {{ $msg->created_at->format('H:i') }}
                                        @if($msg->sender_id == Auth::id())
                                            <i class="fas fa-check-double ms-1 {{ $msg->is_read ? 'text-info' : '' }}"></i>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="p-3 shadow-sm" 
                                    style="max-width: 75%; font-size: 0.95rem; line-height: 1.5; border-radius: 18px;
                                            {{ $msg->sender_id == Auth::id() 
                                            ? 'background-color: #0f2f57; color: white; border-bottom-right-radius: 4px;' 
                                            : 'background-color: white; color: #333; border-bottom-left-radius: 4px; border: 1px solid #e0e0e0;' }}">
                                    
                                    <div style="white-space: pre-wrap; word-break: break-word;">{!! preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', e($msg->message)) !!}</div>
                                    
                                    <div class="text-end mt-2" style="font-size: 0.65rem; opacity: 0.7;">
                                        {{ $msg->created_at->format('H:i') }}
                                        @if($msg->sender_id == Auth::id())
                                            <i class="fas fa-check-double ms-1 {{ $msg->is_read ? 'text-info' : '' }}"></i>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                        </div>
                    @endforeach
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