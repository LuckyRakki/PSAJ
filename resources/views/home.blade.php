@extends('layouts.app')

@section('title', 'Wiratama Teknik - Sewa Genset & AC Standing')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Sewa Genset & AC Standing Terpercaya di Tangerang</h1>
                    <p class="lead mb-4">Melayani penyewaan untuk berbagai kebutuhan acara seperti syuting, konser, hajatan, dan kegiatan lainnya dengan kualitas terbaik dan harga kompetitif.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#products" class="btn btn-primary btn-lg px-4 py-3">
                            <i class="fas fa-tools me-2"></i> Lihat Produk
                        </a>
                        <a href="{{ route('pricing') }}" class="btn btn-outline-light btn-lg px-4 py-3">
                            <i class="fas fa-tag me-2"></i> Lihat Harga
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1621905252507-b35492cc74b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Genset" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col">
                    <h2 class="section-title d-inline-block">Mengapa Memilih Kami?</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5>Terpercaya</h5>
                        <p>Sudah berpengalaman melayani berbagai acara dengan reputasi terpercaya</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h5>Pengiriman Cepat</h5>
                        <p>Proses pengiriman cepat dan tepat waktu sesuai jadwal acara Anda</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h5>Perawatan Rutin</h5>
                        <p>Semua unit mendapatkan perawatan rutin untuk performa optimal</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5>Support 24/7</h5>
                        <p>Dukungan teknis siap membantu selama masa penyewaan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Tentang Wiratama Teknik" class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title">Tentang Wiratama Teknik</h2>
                    <p class="mb-4">Wiratama Teknik adalah usaha penyewaan genset dan AC standing yang berlokasi di Tangerang. Kami telah melayani berbagai kebutuhan acara seperti syuting film, konser musik, hajatan, pernikahan, dan acara besar lainnya.</p>
                    <p class="mb-4">Dengan pengalaman bertahun-tahun, kami memahami pentingnya keandalan peralatan untuk kesuksesan acara Anda. Kami menyediakan unit yang terawat baik dengan kapasitas yang beragam untuk memenuhi kebutuhan Anda.</p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Unit terawat dan performa optimal</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Tersedia berbagai kapasitas daya</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Pelayanan cepat dan responsif</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Harga transparan dan kompetitif</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <h2 class="section-title">Produk Kami</h2>
                    <p class="lead">Pilih genset atau AC standing sesuai kebutuhan acara Anda</p>
                </div>
            </div>
            
            <!-- Genset Products -->
            <div class="row mb-5">
                <div class="col">
                    <h4 class="mb-4"><i class="fas fa-bolt text-warning me-2"></i> Genset</h4>
                </div>
            </div>
            <div class="row">
                @foreach($gensetProducts as $product)
                <div class="col-md-4 mb-4">
                    <div class="card product-card h-100">
                        <img src="{{ $product['image'] }}" class="card-img-top product-img" alt="{{ $product['name'] }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product['name'] }}</h5>
                            <p class="card-text flex-grow-1">{{ $product['description'] }}</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="h5 text-primary mb-0">Rp {{ number_format($product['price_per_day'], 0, ',', '.') }}/hari</span>
                                    <span class="badge bg-success">Tersedia</span>
                                </div>
                                <a href="{{ route('product.detail', ['type' => 'genset', 'id' => $product['id']]) }}" class="btn btn-primary w-100">
                                    <i class="fas fa-info-circle me-2"></i> Detail & Sewa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- AC Products -->
            <div class="row mt-5">
                <div class="col">
                    <h4 class="mb-4"><i class="fas fa-snowflake text-info me-2"></i> AC Standing</h4>
                </div>
            </div>
            <div class="row">
                @foreach($acProducts as $product)
                <div class="col-md-4 mb-4">
                    <div class="card product-card h-100">
                        <img src="{{ $product['image'] }}" class="card-img-top product-img" alt="{{ $product['name'] }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product['name'] }}</h5>
                            <p class="card-text flex-grow-1">{{ $product['description'] }}</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="h5 text-primary mb-0">Rp {{ number_format($product['price_per_day'], 0, ',', '.') }}/hari</span>
                                    <span class="badge bg-success">Tersedia</span>
                                </div>
                                <a href="{{ route('product.detail', ['type' => 'ac', 'id' => $product['id']]) }}" class="btn btn-primary w-100">
                                    <i class="fas fa-info-circle me-2"></i> Detail & Sewa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <h2 class="section-title">Hubungi Kami</h2>
                    <p class="lead">Siap melayani kebutuhan penyewaan genset dan AC standing untuk acara Anda</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Informasi Kontak</h5>
                            <div class="mb-3">
                                <h6><i class="fas fa-map-marker-alt text-primary me-2"></i> Alamat</h6>
                                <p class="ms-4">Tangerang, Banten - Indonesia</p>
                            </div>
                            <div class="mb-3">
                                <h6><i class="fas fa-phone text-primary me-2"></i> Telepon/WhatsApp</h6>
                                <p class="ms-4">+62 812-3456-7890</p>
                            </div>
                            <div class="mb-3">
                                <h6><i class="fas fa-envelope text-primary me-2"></i> Email</h6>
                                <p class="ms-4">info@wiratamateknik.com</p>
                            </div>
                            <div class="mb-3">
                                <h6><i class="fas fa-clock text-primary me-2"></i> Jam Operasional</h6>
                                <p class="ms-4">Senin - Jumat: 08:00 - 17:00 WIB<br>Sabtu: 08:00 - 15:00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Kirim Pesan</h5>
                            <form action="#" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="phone" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Pesan</label>
                                    <textarea class="form-control" id="message" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .hero-section h1 {
            font-size: 3rem;
        }
        
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.2rem;
            }
            body {
                padding-top: 66px;
            }
        }
    </style>
@endpush