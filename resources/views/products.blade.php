@extends('layouts.app')

@section('content')

<style>
    .page-hero {
        background: linear-gradient(rgba(15, 47, 87, 0.9), rgba(15, 47, 87, 0.9)), url('https://images.unsplash.com/photo-1565610222536-ef125c59da2c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
        background-size: cover;
        background-position: center;
        padding: 60px 0 100px 0;
        color: white;
        position: relative;
    }

    .yellow-bar-title {
        background-color: #ffc107;
        color: #0f2f57;
        font-weight: bold;
        text-align: center;
        padding: 15px;
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
        border-radius: 5px;
        position: relative;
        margin-top: -30px;
        z-index: 10;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .filter-sidebar { padding-right: 20px; }
    .filter-title {
        font-weight: 600;
        color: #333;
        font-size: 1.2rem;
        margin-bottom: 20px;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    .prod-card-full {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        overflow: hidden;
        height: 100%;
        transition: transform 0.2s;
        display: flex;
        flex-direction: column;
    }
    .prod-card-full:hover { transform: translateY(-5px); }
    
    .prod-img-box {
        background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .prod-img-box img {
        max-height: 180px;
        max-width: 100%;
        object-fit: contain;
        filter: drop-shadow(0 10px 10px rgba(0,0,0,0.2)); 
    }
    .prod-body {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .prod-name {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 8px;
        color: #222;
    }
    .prod-desc {
        font-size: 0.8rem;
        color: #666;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .btn-lihat {
        background-color: #ffc107;
        border: none;
        padding: 8px 25px;
        font-weight: 600;
        font-size: 0.85rem;
        border-radius: 4px;
        color: #0f2f57;
        margin-top: auto;
        text-decoration: none;
        text-align: center;
        display: inline-block;
    }
    .btn-lihat:hover { background-color: #e0a800; color: #0f2f57; }
</style>

<div class="page-hero">
    <div class="container">
        <h2 class="display-5 fw-bold mb-3">Sewa Genset & AC Standing Profesional<br>untuk Kebutuhan Anda</h2>
        <p class="mb-0 opacity-75" style="max-width: 700px;">Solusi terpercaya untuk penyewaan genset dan AC standing dengan kualitas terbaik.</p>
    </div>
</div>

<div class="container">
    <div class="yellow-bar-title">Produk Sewa Kami</div>
</div>

<div class="container py-5 mt-3">
    <div class="row">
        
        <!-- Sidebar Filter -->
        <div class="col-md-3 d-none d-md-block filter-sidebar">
            <div class="filter-title">Filter Produk</div>
            
            <div class="form-check mb-2">
                <input class="form-check-input filter-checkbox" type="checkbox" value="genset" id="f1" checked>
                <label class="form-check-label" for="f1">Genset Silent</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input filter-checkbox" type="checkbox" value="ac" id="f2" checked>
                <label class="form-check-label" for="f2">AC Standing</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input filter-checkbox" type="checkbox" value="fan" id="f3" checked>
                <label class="form-check-label" for="f3">Misty Fan</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input filter-checkbox" type="checkbox" value="tenda" id="f4" checked>
                <label class="form-check-label" for="f4">Tenda</label>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-md-9">
            <div class="row g-4" id="product-grid">
                @foreach($allProducts as $product)
                <!-- Tambahkan data-category untuk filtering JS -->
                <div class="col-md-4 col-sm-6 product-item" data-category="{{ $product->category->slug }}">
                    <div class="prod-card-full">
                        <div class="prod-img-box">
                            <img src="{{ $product->image }}" alt="{{ $product['name'] }}">
                        </div>
                        <div class="prod-body">
                            <h5 class="prod-name">{{ $product['name'] }}</h5>
                            <p class="prod-desc">{{ $product['desc'] }}</p>
                            <a href="{{ route('product.detail', $product['id']) }}" class="btn-lihat">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pesan jika kosong -->
            <div id="no-products" class="alert alert-warning mt-3 text-center" style="display: none;">
                Tidak ada produk yang sesuai dengan filter.
            </div>
        </div>

    </div>
</div>

<!-- Script Javascript untuk Filter -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.filter-checkbox');
        const products = document.querySelectorAll('.product-item');
        const noProductsMsg = document.getElementById('no-products');

        function filterProducts() {
            // Ambil semua value checkbox yang dicentang
            const activeCategories = Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            let visibleCount = 0;

            products.forEach(product => {
                const category = product.getAttribute('data-category');
                
                // Cek apakah kategori produk ada di list yang dicentang
                if (activeCategories.includes(category)) {
                    product.style.display = 'block';
                    visibleCount++;
                } else {
                    product.style.display = 'none';
                }
            });

            // Tampilkan pesan jika tidak ada produk
            if (visibleCount === 0) {
                noProductsMsg.style.display = 'block';
            } else {
                noProductsMsg.style.display = 'none';
            }
        }

        // Pasang event listener ke setiap checkbox
        checkboxes.forEach(cb => {
            cb.addEventListener('change', filterProducts);
        });
    });
</script>

@endsection