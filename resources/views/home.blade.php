@extends('layouts.app')

@section('content')

<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(rgba(15, 47, 87, 0.85), rgba(15, 47, 87, 0.85)), url('https://images.unsplash.com/photo-1565610222536-ef125c59da2c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
        background-size: cover;
        background-position: center;
        padding: 100px 0;
        color: white;
    }
    .hero-img {
        max-width: 100%;
        border-radius: 5px;
        /* Meniru gambar genset kuning di header */
        content: url('https://png.pngtree.com/png-clipart/20230916/original/pngtree-industrial-diesel-generator-isolated-on-white-background-backup-power-photo-png-image_12249764.png'); 
    }

    /* Yellow About Section */
    .about-section {
        background-color: #ffc107; /* Kuning terang */
        padding: 80px 0;
    }
    .about-img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    /* Category Cards */
    .cat-card {
        border: 1px solid #eee;
        transition: 0.3s;
        height: 100%;
        background: white;
    }
    .cat-card img {
        height: 150px;
        object-fit: contain;
        padding: 20px;
    }
    .cat-btn {
        background-color: #0f2f57;
        color: white;
        width: 100%;
        border-radius: 0 0 5px 5px;
        padding: 10px;
        font-size: 0.9rem;
    }

    /* Product Cards */
    .product-card {
        background: #f8f9fa; /* Abu-abu muda seperti di gambar */
        border: none;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .product-img-wrapper {
        background: #e9ecef; /* Background abu-abu untuk gambar produk */
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-img-wrapper img {
        max-height: 160px;
        max-width: 80%;
    }
    .product-body { padding: 20px; }
    .product-title { font-weight: 700; font-size: 1rem; color: #333; margin-bottom: 10px; }
    .product-desc { font-size: 0.8rem; color: #666; line-height: 1.5; margin-bottom: 20px; }
    .btn-detail {
        background-color: #ffc107;
        color: #000;
        font-weight: 600;
        font-size: 0.8rem;
        padding: 8px 20px;
        border: none;
        border-radius: 4px;
    }
    .btn-detail:hover { background-color: #e0a800; }
</style>

<!-- 1. Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-3">Sewa Genset & AC Standing Profesional untuk Kebutuhan Anda</h1>
                <p class="mb-4 text-light opacity-75">Solusi terpercaya untuk penyewaan genset dan AC standing dengan kualitas terbaik. Layanan 24 jam untuk acara, proyek, maupun kebutuhan darurat.</p>
                <a href="#produk" class="btn btn-warning px-4 py-2 fw-bold">Lihat Produk</a>
            </div>
            <div class="col-lg-6 d-none d-lg-block text-end">
                <img class="hero-img" alt="Genset Kuning">
            </div>
        </div>
    </div>
</section>

<!-- 2. About Section (Kuning) -->
<section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <!-- Gambar Genset Hijau/Biru di kiri -->
                <img src="https://sc04.alicdn.com/kf/H8a846059530449419159040960534262W.jpg" class="about-img" alt="Genset Facility">
            </div>
            <div class="col-lg-7 ps-lg-5">
                <h4 class="fw-bold mb-3">Wiratama Teknik</h4>
                <p class="mb-3">Wiratama Teknik adalah usaha penyewaan genset dan AC standing yang berlokasi di Tangerang. Kami telah melayani berbagai kebutuhan acara seperti syuting film, konser musik, hajatan, pernikahan, dan acara besar lainnya.</p>
                <p>Dengan pengalaman bertahun-tahun, kami memahami pentingnya keandalan peralatan untuk kesuksesan acara Anda. Kami menyediakan unit yang terawat baik dengan kapasitas yang beragam untuk memenuhi kebutuhan Anda.</p>
            </div>
        </div>
    </div>
</section>

<!-- 3. Kategori Produk (Grid 5 Kolom) -->
<!-- 3. Kategori Produk (Grid 5 Kolom) -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center g-4">
            @foreach($categories as $cat)
            <div class="col-6 col-md-2"> 
                <!-- TAMBAHKAN TAG A DI SINI -->
                <a href="{{ route('products') }}" style="text-decoration: none; color: inherit;">
                    <div class="cat-card d-flex flex-column align-items-center">
                        <img src="{{ $cat['image'] }}" alt="{{ $cat['name'] }}">
                        <div class="cat-btn text-center">{{ $cat['name'] }}</div>
                    </div>
                </a>
                <!-- END TAG A -->
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 4. Produk Unggulan -->
<section class="py-5 bg-white" id="produk">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Produk Unggulan Kami</h2>
            <p class="text-muted">Produk paling populer dan terlaris pilihan pelanggan kami.</p>
        </div>

        <!-- INI KODE BARU YANG BENAR. HANYA ADA SATU GRID. -->
        <div class="row g-4 justify-content-center">
            @forelse($featuredProducts as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 d-flex">
                <div class="product-card w-100">
                    <div class="product-img-wrapper">
                        <!-- Menggunakan object property -> bukan array key [] -->
                        <img src="{{ $item->image }}" alt="{{ $item->name }}">
                    </div>
                    <div class="product-body">
                        <div class="product-title">{{ $item->name }}</div>
                        <div class="product-desc">{{ $item->description }}</div>
                        <a href="{{ route('product.detail', $item->id) }}" class="btn-detail mt-auto">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-center text-muted">Belum ada produk unggulan yang bisa ditampilkan.</p>
            </div>
            @endforelse
        </div>
        
    </div>
</section>

@endsection