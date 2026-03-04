@extends('layouts.app')

@section('content')

<style>
    body { background-color: #f5f7fa; }
    .detail-container { margin-top: 30px; margin-bottom: 80px; }
    
    /* Breadcrumb Style */
    .breadcrumb-item a { color: #0f2f57; text-decoration: none; font-weight: 500; }
    .breadcrumb-item.active { color: #888; }
    .breadcrumb { margin-bottom: 20px; background: transparent; padding: 0; }

    /* Main Image Card */
    .main-image-card {
        background: white;
        background: radial-gradient(circle, rgba(255,255,255,1) 0%, rgba(220,224,230,1) 100%);
        border-radius: 10px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        border: 1px solid #eee;
    }
    .main-image-card img {
        max-width: 100%;
        max-height: 400px;
        object-fit: contain;
        filter: drop-shadow(0 15px 15px rgba(0,0,0,0.3));
    }

    /* Content Card */
    .content-card {
        background: white;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #eee;
    }
    .product-title { font-size: 2rem; font-weight: 700; color: #0f2f57; margin-bottom: 5px; }
    .product-category { color: #888; font-size: 1rem; margin-bottom: 20px; }
    .product-desc { color: #444; line-height: 1.8; margin-bottom: 30px; }

    /* Spec Box */
    .spec-box { background-color: #f1f3f5; border-radius: 8px; padding: 20px; margin-bottom: 15px; }
    .spec-label { font-size: 0.8rem; color: #888; margin-bottom: 2px; }
    .spec-value { font-size: 1.1rem; font-weight: 500; color: #333; }

    .btn-add {
        background-color: #ffc107;
        color: #0f2f57;
        font-weight: 600;
        padding: 12px 30px;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        transition: 0.3s;
    }
    .btn-add:hover { background-color: #e0a800; transform: translateY(-2px); }
</style>

<div class="container detail-container">
    
    <!-- TAMBAHAN: Breadcrumb Navigasi -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product['name'] }}</li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-12">
            <div class="main-image-card">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="content-card">
                <h1 class="product-title">{{ $product['name'] }}</h1>
                <p class="product-category">Kategori: {{ $product->category->name }} / Professional Equipment</p>
                
                <p class="product-desc">
                    {{ $product['desc'] }}
                    <br><br>
                    Produk dari Wiratama Teknik merupakan solusi terbaik untuk kebutuhan acara maupun backup listrik di lingkungan yang memerlukan tingkat keandalan tinggi.
                </p>

                @if(!empty($product->specs))
                    <h4 class="fw-bold mb-3">Spesifikasi Utama</h4>
                    <div class="row mb-4">
                        @foreach($product->specs as $label => $value)
                        <div class="col-md-6">
                            <div class="spec-box">
                                <div class="spec-label">{{ $label }}</div>
                                <div class="spec-value">{{ $value }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-4 d-flex justify-content-center align-items-center">
                    @auth
                        <form action="{{ route('chat.send_product', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-add">
                                <i class="fas fa-comment-dots me-2"></i> Tanya Harga & Ketersediaan
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-add text-decoration-none" style="display: inline-block;">
                            <i class="fas fa-sign-in-alt me-2"></i> Login untuk Menyewa
                        </a>
                    @endauth

                    <a href="{{ route('products') }}" class="btn btn-outline-secondary ms-2" style="padding: 12px 30px;">
                        Kembali ke List
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection