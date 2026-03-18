@extends('layouts.app')

@section('content')

<style>
    body { background-color: #f8fafc; }
    
    .detail-container { 
        margin-top: 40px; 
        margin-bottom: 80px; 
        /* max-width dihapus agar menggunakan lebar container bawaan Bootstrap yang proporsional */
    }
    
    .breadcrumb-item a { color: #0f2f57; text-decoration: none; font-weight: 600; }
    .breadcrumb-item.active { color: #64748b; }
    .breadcrumb { margin-bottom: 25px; background: transparent; padding: 0; }

    /* Card Gambar di Kiri */
    .main-image-card {
        background-color: #e9ecef; 
        border-radius: 16px; 
        height: 100%; 
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }
    
    .main-image-card img {
        width: 100%; 
        max-height: 450px;
        object-fit: contain; 
        filter: drop-shadow(0 15px 25px rgba(0,0,0,0.15)); 
        transition: transform 0.3s ease;
    }
    .main-image-card img:hover {
        transform: scale(1.05); /* Efek zoom sedikit pas di-hover */
    }

    /* Card Teks di Kanan */
    .content-card {
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .product-title { font-size: 2.2rem; font-weight: 700; color: #0f2f57; margin-bottom: 5px; }
    .product-category { color: #64748b; font-size: 1rem; margin-bottom: 25px; font-weight: 500; }
    .product-desc { color: #475569; line-height: 1.8; margin-bottom: 30px; font-size: 1.05rem; }

    /* Spec Box */
    .spec-box { 
        background-color: #f1f5f9; 
        border-radius: 10px; 
        padding: 15px 20px; 
        margin-bottom: 15px; 
        border: 1px solid #e2e8f0;
    }
    .spec-label { font-size: 0.85rem; color: #64748b; margin-bottom: 5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .spec-value { font-size: 1.15rem; font-weight: 700; color: #0f2f57; }

    /* Tombol Aksi */
    .btn-add {
        background-color: #ffc107;
        color: #0f2f57;
        font-weight: 700;
        padding: 14px 30px;
        border: none;
        border-radius: 8px;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px rgba(255, 193, 7, 0.3);
        width: 100%;
    }
    .btn-add:hover { 
        background-color: #e0a800; 
        transform: translateY(-3px); 
        box-shadow: 0 6px 12px rgba(255, 193, 7, 0.4);
        color: #0f2f57;
    }
    
    .btn-back {
        padding: 14px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        width: 100%;
        text-align: center;
    }
</style>

<div class="container detail-container">
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        
        <div class="col-lg-5">
            <div class="main-image-card">
                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->name }}">
            </div>
        </div>

        <div class="col-lg-7">
            <div class="content-card">
                <h1 class="product-title">{{ $product->name }}</h1>
                <p class="product-category">
                    <i class="fas fa-tag me-2 text-warning"></i>Kategori: {{ $product->category->name ?? 'Umum' }}
                </p>
                
                <div class="product-desc flex-grow-1">
                    {{ $product->description ?? $product->desc }}
                    <br><br>
                    Produk dari Wiratama Teknik merupakan solusi terbaik untuk kebutuhan acara maupun backup listrik di lingkungan yang memerlukan tingkat keandalan tinggi. Kami menjamin perawatan rutin untuk setiap unit.
                </div>

                @if(!empty($product->specs))
                    <h5 class="fw-bold mb-3 text-dark">Spesifikasi Utama</h5>
                    <div class="row mb-4">
                        @foreach($product->specs as $label => $value)
                        <div class="col-sm-6">
                            <div class="spec-box">
                                <div class="spec-label">{{ $label }}</div>
                                <div class="spec-value">{{ $value }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif

                <hr class="opacity-25 my-4">

                <div class="row g-3">
                    <div class="col-sm-7">
                        @auth
                            <form action="{{ route('chat.send_product', $product->id) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn-add">
                                    <i class="fas fa-comment-dots me-2 fa-lg"></i> Tanya Ketersediaan
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn-add">
                                <i class="fas fa-sign-in-alt me-2 fa-lg"></i> Login untuk Menyewa
                            </a>
                        @endauth
                    </div>
                    <div class="col-sm-5">
                        <a href="{{ route('products') }}" class="btn btn-outline-secondary btn-back d-block">
                            Kembali
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection