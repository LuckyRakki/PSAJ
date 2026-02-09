@extends('layouts.admin')

@section('content')
<div class="row g-0 rounded shadow-sm overflow-hidden" style="min-height: 75vh; border: 1px solid #e0e0e0;">
    
    <div class="col-md-4 bg-white border-end">
        <div class="p-3 bg-light border-bottom">
            <h6 class="mb-0 fw-bold"><i class="fas fa-users me-2"></i>Daftar Chat</h6>
        </div>
        <div class="list-group list-group-flush overflow-auto" style="max-height: 70vh;">
            @forelse($users as $user)
                <a href="{{ route('admin.chat', $user->id) }}" 
                   class="list-group-item list-group-item-action py-3 {{ isset($currentUser) && $currentUser->id == $user->id ? 'active' : '' }}">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3" 
                                 style="width: 40px; height: 40px; font-weight: bold;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="mb-0 {{ isset($currentUser) && $currentUser->id == $user->id ? 'text-white' : 'text-dark' }}">{{ $user->name }}</h6>
                                <small class="{{ isset($currentUser) && $currentUser->id == $user->id ? 'text-light opacity-75' : 'text-muted' }}">
                                    Klik untuk baca chat
                                </small>
                            </div>
                        </div>
                        @if($user->unread > 0)
                            <span class="badge bg-danger rounded-pill">{{ $user->unread }}</span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="p-4 text-center text-muted">
                    <small>Belum ada user yang memulai chat.</small>
                </div>
            @endforelse
        </div>
    </div>

    <div class="col-md-8 bg-light d-flex flex-column">
        @if(isset($currentUser))
            <div class="p-3 bg-white border-bottom shadow-sm d-flex align-items-center">
                <div class="fw-bold text-primary">
                    <i class="fas fa-comment-alt me-2"></i> {{ $currentUser->name }}
                </div>
            </div>

            <div class="flex-grow-1 p-4 overflow-auto" id="chatBox" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
                @foreach($messages as $msg)
                    <div class="d-flex mb-3 {{ $msg->sender_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="p-3 rounded-3 shadow-sm" 
                             style="max-width: 70%; 
                                    {{ $msg->sender_id == Auth::id() 
                                       ? 'background-color: #0f2f57; color: white; border-bottom-right-radius: 0;' 
                                       : 'background-color: white; color: black; border-bottom-left-radius: 0;' }}">
                            <div>{{ $msg->message }}</div>
                            <div class="text-end mt-1" style="font-size: 0.7rem; opacity: 0.7;">
                                {{ $msg->created_at->format('H:i, d M') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-3 bg-white border-top">
                <form action="{{ route('admin.chat.reply', $currentUser->id) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="message" class="form-control" placeholder="Tulis balasan..." required autofocus>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i> Kirim</button>
                    </div>
                </form>
            </div>
        @else
            <div class="h-100 d-flex flex-column justify-content-center align-items-center text-secondary opacity-50">
                <i class="fas fa-comments fa-5x mb-3"></i>
                <h5>Pilih user di sebelah kiri untuk mulai chat</h5>
            </div>
        @endif
    </div>
</div>

<script>
    // Auto Scroll ke bawah jika ada chat
    document.addEventListener("DOMContentLoaded", function() {
        var chatBox = document.getElementById("chatBox");
        if(chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    });
</script>
@endsection