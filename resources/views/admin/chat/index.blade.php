@extends('layouts.admin')

@section('content')
<div class="row g-0 rounded shadow-sm overflow-hidden bg-white" style="height: 85vh; border: 1px solid #e0e0e0;">
    
    <div class="col-md-3 border-end d-flex flex-column h-100 d-none d-md-flex">
        <div class="p-3 bg-light border-bottom flex-shrink-0">
            <h6 class="mb-0 fw-bold text-secondary"><i class="fas fa-users me-2"></i>Pelanggan</h6>
        </div>
        <div class="list-group list-group-flush overflow-auto flex-grow-1">
            @forelse($users as $user)
                <a href="{{ route('admin.chat', $user->id) }}" 
                   class="list-group-item list-group-item-action py-3 {{ (isset($currentUser) && $currentUser->id == $user->id) ? 'active' : '' }}">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" 
                                 style="width: 35px; height: 35px; font-weight: bold; font-size: 0.8rem;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="text-truncate" style="max-width: 120px;">
                                <h6 class="mb-0 small fw-bold {{ (isset($currentUser) && $currentUser->id == $user->id) ? 'text-white' : 'text-dark' }}">{{ $user->name }}</h6>
                            </div>
                        </div>
                        @if($user->unread > 0)
                            <span class="badge bg-danger rounded-pill">{{ $user->unread }}</span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="p-4 text-center text-muted small">Belum ada chat.</div>
            @endforelse
        </div>
    </div>

    <div class="col-md-6 d-flex flex-column border-end bg-light h-100">
        @if(isset($currentUser))
            <div class="p-3 bg-white border-bottom shadow-sm flex-shrink-0 d-flex justify-content-between align-items-center">
                <div class="fw-bold text-primary">
                    <i class="fas fa-comment-alt me-2"></i> {{ $currentUser->name }}
                </div>
            </div>

            <div class="flex-grow-1 p-4 overflow-auto" id="chatBox" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
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
                                    <h6 class="mb-1 fw-bold text-dark text-truncate" style="font-size: 0.9rem;" title="{{ $pName }}">{{ $pName }}</h6>
                                    <small class="text-muted d-block mb-3 text-truncate" style="font-size: 0.75rem;"><i class="fas fa-tag me-1"></i> {{ $pCat }}</small>
                                    <a href="{{ route('product.detail', $pId) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100 fw-bold rounded-pill" style="font-size: 0.8rem;">
                                        <i class="fas fa-external-link-alt me-1"></i> Cek Produk
                                    </a>
                                </div>
                                <div class="card-footer bg-white border-0 text-end py-1" style="font-size: 0.65rem; color: #aaa;">
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

            <div class="p-3 bg-white border-top flex-shrink-0">
                <form action="{{ route('admin.chat.reply', $currentUser->id) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="message" class="form-control" placeholder="Tulis balasan..." required autocomplete="off">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>
        @else
            <div class="h-100 d-flex flex-column justify-content-center align-items-center text-secondary opacity-50">
                <i class="fas fa-comments fa-4x mb-3"></i>
                <p>Pilih pelanggan untuk mulai chat</p>
            </div>
        @endif
    </div>

    <div class="col-md-3 bg-white p-0 d-flex flex-column h-100">
        @if(isset($currentUser))
            <div class="p-3 bg-light border-bottom flex-shrink-0">
                <h6 class="mb-0 fw-bold text-secondary"><i class="fas fa-file-invoice-dollar me-2"></i>Tagihan</h6>
            </div>
            <div class="p-3 border-bottom flex-shrink-0">
                <form action="{{ route('admin.chat.invoice', $currentUser->id) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="small fw-bold text-muted mb-1">Pilih Produk</label>
                        <select id="productSelect" class="form-select form-select-sm mb-2">
                            <option value="" selected>-- Pilih Produk --</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" data-name="Sewa {{ $p->name }}" data-price="{{ $p->specs['Harga Sewa'] ?? 500000 }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <input type="text" name="title" id="invoiceTitle" class="form-control form-control-sm mb-1" placeholder="Judul (ex: Sewa Genset)" required>
                        <input type="number" name="amount" id="invoiceAmount" class="form-control form-control-sm mt-2" placeholder="Harga (ex: 500000)" required>
                    </div>
                    <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold text-dark mt-1">Kirim Tagihan</button>
                </form>
            </div>
            
            <div class="flex-grow-1 overflow-auto p-3">
                @php 
                    // LOGIKA EXPIRED 24 JAM:
                    // Tampilkan invoice yang sudah PAID, ATAU yang belum dibayar TAPI umurnya kurang dari 24 jam
                    $invoices = \App\Models\Invoice::where('user_id', $currentUser->id)
                        ->where(function($query) {
                            $query->where('status', 'paid')
                                  ->orWhere('created_at', '>=', now()->subHours(24));
                        })
                        ->latest()->get(); 
                @endphp
                
                @forelse($invoices as $inv)
                    <div class="card mb-3 border bg-light shadow-sm">
                        <div class="card-body p-2">
                            <div class="small fw-bold text-truncate">{{ $inv->title }}</div>
                            <div class="d-flex justify-content-between align-items-center mt-1 mb-2">
                                <span class="text-primary small fw-bold">Rp {{ number_format($inv->amount, 0, ',', '.') }}</span>
                                
                                @if($inv->status == 'pending') 
                                    <span class="badge bg-secondary" style="font-size: 0.6rem;">Pending</span>
                                @elseif($inv->status == 'confirmed' || $inv->status == 'waiting_verification') 
                                    <span class="badge bg-danger" style="font-size: 0.6rem;">Belum Bayar</span>
                                @elseif($inv->status == 'paid') 
                                    <span class="badge bg-success" style="font-size: 0.6rem;">Lunas</span>
                                @endif
                            </div>
                            
                            @if($inv->status != 'paid')
                                <form action="{{ route('admin.invoice.approve', $inv->id) }}" method="POST" onsubmit="return confirm('Tandai tagihan ini Lunas? (Gunakan jika user bayar Cash)');">
                                    @csrf 
                                    <button type="submit" class="btn btn-xs btn-outline-success w-100 mb-1">
                                        <i class="fas fa-check me-1"></i> Tandai Lunas (Manual)
                                    </button>
                                </form>
                            @endif

                            @if($inv->status != 'pending')
                                <button class="btn btn-xs btn-outline-dark w-100 mt-1" type="button" data-bs-toggle="collapse" data-bs-target="#detail-{{$inv->id}}">
                                    Detail Data Sewa
                                </button>
                                <div class="collapse mt-2 small bg-white p-2 border rounded" id="detail-{{$inv->id}}">
                                    <strong>Penyewa:</strong> {{ $inv->nama_penyewa }}<br>
                                    <strong>No HP:</strong> {{ $inv->no_hp }}<br>
                                    <strong>Alamat:</strong> {{ $inv->alamat_pengiriman }}<br>
                                    <strong>Tgl Sewa:</strong> {{ $inv->tanggal_mulai }} ({{ $inv->durasi_sewa }} hari)
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center small text-muted">Belum ada tagihan aktif.</p>
                @endforelse
            </div>
        @else
            <div class="h-100 d-flex justify-content-center align-items-center text-muted"><small>Pilih user</small></div>
        @endif
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var chatBox = document.getElementById("chatBox");
        // Beri sedikit delay agar gambar render dulu baru scroll ke bawah
        if(chatBox) {
            setTimeout(function() {
                chatBox.scrollTop = chatBox.scrollHeight;
            }, 100);
        }

        // Script dropdown harga
        const productSelect = document.getElementById('productSelect');
        const titleInput = document.getElementById('invoiceTitle');
        const amountInput = document.getElementById('invoiceAmount');
        if(productSelect) {
            productSelect.addEventListener('change', function() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const name = selectedOption.getAttribute('data-name');
                const price = selectedOption.getAttribute('data-price');
                if(name) titleInput.value = name;
                if(price) amountInput.value = price; else amountInput.value = 100000;
            });
        }
    });
</script>
@endsection