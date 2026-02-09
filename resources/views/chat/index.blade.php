@extends('layouts.app')

@section('content')
<style>
    /* Custom Scrollbar */
    .chat-box::-webkit-scrollbar { width: 6px; }
    .chat-box::-webkit-scrollbar-track { background: #f1f1f1; }
    .chat-box::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
    
    /* Chat Bubbles */
    .message-bubble {
        max-width: 75%;
        padding: 10px 15px;
        border-radius: 15px;
        position: relative;
        font-size: 0.95rem;
    }
    .message-sent {
        background-color: #0f2f57; /* Warna Primary Blue Anda */
        color: white;
        border-bottom-right-radius: 2px;
    }
    .message-received {
        background-color: #e9ecef;
        color: #333;
        border-bottom-left-radius: 2px;
    }
    .message-time {
        font-size: 0.65rem;
        margin-top: 4px;
        display: block;
        opacity: 0.8;
        text-align: right;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between" style="background-color: #0f2f57 !important;">
                    <div class="d-flex align-items-center">
                        <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                            <i class="fas fa-headset fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Admin Wiratama</h6>
                            <small class="text-warning" style="font-size: 0.75rem;">Online</small>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="text-white"><i class="fas fa-times"></i></a>
                </div>

                <div class="card-body chat-box bg-light" id="chatContainer" style="height: 450px; overflow-y: auto; background-image: url('https://www.transparenttextures.com/patterns/subtle-grey.png');">
                    @forelse($messages as $msg)
                        @if($msg->sender_id == Auth::id())
                            <div class="d-flex justify-content-end mb-3">
                                <div class="message-bubble message-sent shadow-sm">
                                    {{ $msg->message }}
                                    <span class="message-time">
                                        {{ $msg->created_at->format('H:i') }} 
                                        <i class="fas fa-check-double ms-1"></i>
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="d-flex justify-content-start mb-3">
                                <div class="message-bubble message-received shadow-sm">
                                    {{ $msg->message }}
                                    <span class="message-time">{{ $msg->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center mt-5 text-muted">
                            <i class="fas fa-comments fa-3x mb-3 text-secondary opacity-25"></i>
                            <p>Belum ada pesan.<br>Silakan tanya mengenai stok Genset atau AC.</p>
                        </div>
                    @endforelse
                </div>

                <div class="card-footer bg-white p-3 border-top">
                    <form action="{{ route('chat.send') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" class="form-control border-0 bg-light rounded-start-pill ps-3" placeholder="Tulis pesan..." required autofocus>
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
    // Fungsi untuk auto-scroll ke bawah saat halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
        var chatBox = document.getElementById("chatContainer");
        chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>
@endsection