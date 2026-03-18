@extends('layouts.app')

@section('content')

<style>
    /* Hero Section Baru */
    .hero-section {
        /* Ini rahasianya: Gradient dari biru pekat di kiri (0-50%), lalu memudar transparan di kanan (100%), menimpa gambar genset */
        background-image: 
            linear-gradient(to right, rgba(15, 47, 87, 1) 0%, rgba(15, 47, 87, 0.9) 45%, rgba(15, 47, 87, 0.1) 100%), 
            url('{{ asset("images/genset-dashboard.png") }}');
        background-color: #0f2f57; /* Fallback warna biru gelap */
        background-size: 65%; /* Mengatur seberapa besar gambar gensetnya (bisa diubah-ubah misal 70% atau cover) */
        background-position: right center; /* Memaksa gambar genset nempel di kanan */
        background-repeat: no-repeat;
        padding: 130px 0 150px 0;
        color: white;
    }

    /* Garis kuning kecil di bawah judul seperti di desain */
    .title-accent {
        width: 80px;
        height: 5px;
        background-color: #ffc107;
        margin-bottom: 25px;
        border-radius: 3px;
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

/* Category Cards - Desain Baru (Lebar & Elegan) */
    .cat-card {
        border: 1px solid #e2e8f0;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        background: white;
        border-radius: 8px; /* Ujung agak membulat tapi tidak terlalu bulat */
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .cat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(15, 47, 87, 0.08);
    }
    .cat-img-wrapper {
        padding: 40px 20px; /* Jarak putih yang lega di atas/bawah gambar */
        display: flex;
        align-items: center;
        justify-content: center;
        flex-grow: 1; /* Mendorong tombol biru agar mentok ke bawah */
        background-color: white;
    }
    .cat-card img {
        max-height: 110px; /* Membatasi tinggi gambar agar proporsional */
        max-width: 100%;
        object-fit: contain;
    }
    .cat-btn {
        background-color: #0f2f57;
        color: white;
        width: 100%;
        padding: 15px; /* Tombol dibuat lebih tebal */
        font-size: 1.05rem;
        font-weight: 700;
        text-align: center;
        letter-spacing: 0.5px;
        margin-top: auto;
    }

    /* Product Cards */
    .product-card {
        background: #f8f9fa;
        border: none;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .product-img-wrapper {
        background: #e9ecef;
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
        text-decoration: none;
    }
    .btn-detail:hover { background-color: #e0a800; color: #000; }
</style>

<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="display-4 fw-bold mb-3" style="line-height: 1.3;">Sewa Genset & AC Standing Profesional Untuk Kebutuhan Anda</h1>
                <div class="title-accent"></div>
                <p class="mb-4 text-light opacity-75 fs-6" style="max-width: 85%;">Solusi terpercaya untuk penyewaan genset dan AC standing dengan kualitas terbaik. Layanan 24 jam untuk acara, proyek, maupun kebutuhan darurat.</p>
                
                <div class="d-flex gap-3 mt-4">
                    <a href="#produk" class="btn btn-warning px-4 py-2 fw-bold rounded-3 shadow">Lihat Produk</a>
                </div>
            </div>
            
            <div class="col-lg-5 d-none d-lg-block">
            </div>
        </div>
    </div>
</section>

<section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <img src="{{ asset('images/genset-dashboard.png') }}" class="about-img" alt="Genset Facility">
            </div>
            <div class="col-lg-7 ps-lg-5">
                <h4 class="fw-bold mb-3">Wiratama Teknik</h4>
                <p class="mb-3 text-dark">Wiratama Teknik adalah usaha penyewaan genset dan AC standing yang berlokasi di Tangerang. Kami telah melayani berbagai kebutuhan acara seperti syuting film, konser musik, hajatan, pernikahan, dan acara besar lainnya.</p>
                <p class="text-dark">Dengan pengalaman bertahun-tahun, kami memahami pentingnya keandalan peralatan untuk kesuksesan acara Anda. Kami menyediakan unit yang terawat baik dengan kapasitas yang beragam untuk memenuhi kebutuhan Anda.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background-color: #f8fafc;">
    <div class="container">
        <div class="row justify-content-center g-4">
            @foreach($categories as $cat)
            <div class="col-12 col-md-6 col-lg-3"> 
                <a href="{{ route('products') }}" style="text-decoration: none; color: inherit;">
                    <div class="cat-card shadow-sm">
                        
                        <div class="cat-img-wrapper">
                            @if(!empty($cat->image))
                                <img src="{{ Str::startsWith($cat->image, 'http') ? $cat->image : asset($cat->image) }}" alt="{{ $cat->name }}">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($cat->name) }}&background=e2e8f0&color=0f2f57&size=120&bold=true" alt="{{ $cat->name }}" style="border-radius: 8px;">
                            @endif
                        </div>
                        
                        <div class="cat-btn">{{ $cat->name }}</div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-5 bg-white" id="produk">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #0f2f57;">Produk Unggulan Kami</h2>
            <p class="text-muted">Produk paling populer dan terlaris pilihan pelanggan kami.</p>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($featuredProducts as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 d-flex">
                <div class="product-card w-100">
                    <div class="product-img-wrapper">
                        <img src="{{ asset($item->image) }}" alt="{{ $item->name }}">
                    </div>
                    <div class="product-body d-flex flex-column">
                        <div class="product-title">{{ $item->name }}</div>
                        <div class="product-desc flex-grow-1">{{ Str::limit($item->description, 60) }}</div>
                        <a href="{{ route('product.detail', $item->id) }}" class="btn-detail text-center mt-3">Lihat Detail</a>
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