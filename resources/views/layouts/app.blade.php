<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wiratama Teknik - Sewa Genset & AC</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #0f2f57;
            --primary-yellow: #ffc107;
            --footer-bg: #102a43;
        }
        body { font-family: 'Poppins', sans-serif; }
        
        .navbar { background-color: var(--primary-blue); padding: 15px 0; }
        .navbar-brand { color: var(--primary-yellow) !important; font-weight: bold; font-size: 1.5rem; }
        .navbar-brand span { color: white; }
        .nav-link { color: rgba(255,255,255,0.8) !important; font-weight: 400; font-size: 0.9rem; }
        .nav-link:hover { color: white !important; }
        .nav-link.active { color: white !important; font-weight: 600; }

        .footer-dark {
        background-color: #0f2f57; /* Warna biru gelap khas Wiratama */
        color: #e2e8f0;
        padding: 60px 0 20px;
    }
    .footer-dark a {
        color: #cbd5e1;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .footer-dark a:hover {
        color: #ffc107; /* Warna kuning saat di-hover */
    }
    .footer-title {
        color: #ffffff;
        font-weight: 700;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }
    .footer-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 3px;
        background-color: #ffc107;
        border-radius: 2px;
    }
    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background-color: rgba(255,255,255,0.1);
        border-radius: 50%;
        margin-right: 10px;
        transition: background-color 0.3s;
    }
    .social-icon:hover {
        background-color: #ffc107;
        color: #0f2f57 !important;
    }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center text-nowrap" href="{{ route('home') }}">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                    @if(isset($app_settings['site_logo']) && !empty($app_settings['site_logo']))
                        <img src="{{ asset($app_settings['site_logo']) }}" alt="Logo" height="40" class="me-2 rounded flex-shrink-0">
                    @else
                        <i class="fas fa-bolt me-2 text-warning flex-shrink-0"></i>
                    @endif
                    
                    <!-- HAPUS text-truncate dan max-width -->
                    <span class="fw-bold text-white shadow-sm">
                        {{ $app_settings['site_name'] ?? 'Wiratama Teknik' }}
                    </span>
                </a>
            <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products') ? 'active' : '' }}" href="{{ route('products') }}">Produk</a>
                    </li>

                    @guest
                        <!-- Jika Belum Login -->
                        <li class="nav-item ms-lg-3">
                            <a href="{{ route('login') }}" class="btn btn-outline-warning btn-sm px-4">Login</a>
                        </li>
                    @else
                        <!-- Jika Sudah Login -->
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle text-warning" href="#" role="button" data-bs-toggle="dropdown">
                                Halo, {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->role == 'admin')
                                    <li><a class="dropdown-item" href="#">Dashboard Admin</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Profil Saya</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer-dark mt-auto">
    <div class="container">
        @php
            // Membaca langsung dari DB agar dinamis (sesuaikan nama tabel/key jika berbeda)
            $siteName = \DB::table('settings')->where('key', 'site_name')->value('value') ?? 'Wiratama Teknik';
            $sitePhone = \DB::table('settings')->where('key', 'site_phone')->value('value') ?? '0812 3456 7890';
            $siteEmail = \DB::table('settings')->where('key', 'site_email')->value('value') ?? 'info@wiratamateknik.com';
            $siteAddress = \DB::table('settings')->where('key', 'site_address')->value('value') ?? 'Jakarta';
        @endphp

        <div class="row g-4 mb-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="footer-title">{{ $siteName }}</h5>
                <p class="small text-light opacity-75 mb-4" style="line-height: 1.8;">
                    Solusi terbaik dan terpercaya untuk kebutuhan penyewaan peralatan teknik dan alat berat. Kami siap mendukung kelancaran proyek dan acara Anda.
                </p>
                <div>
                    <a href="#" class="social-icon text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon text-white"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <h5 class="footer-title">Tautan Cepat</h5>
                <ul class="list-unstyled small" style="line-height: 2.2;">
                    <li><i class="fas fa-angle-right me-2 opacity-50"></i><a href="{{ route('home') }}">Beranda Utama</a></li>
                    <li><i class="fas fa-angle-right me-2 opacity-50"></i><a href="{{ route('products') }}">Katalog Produk</a></li>
                    @auth
                        <li><i class="fas fa-angle-right me-2 opacity-50"></i><a href="{{ route('chat') }}">Chat dengan Admin</a></li>
                    @else
                        <li><i class="fas fa-angle-right me-2 opacity-50"></i><a href="{{ route('login') }}">Masuk / Daftar</a></li>
                    @endauth
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <h5 class="footer-title">Hubungi Kami</h5>
                <ul class="list-unstyled small text-light opacity-75" style="line-height: 2;">
                    <li class="d-flex align-items-start mb-2">
                        <i class="fas fa-map-marker-alt mt-1 me-3 text-warning"></i>
                        <span>{{ $siteAddress }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <i class="fas fa-phone-alt me-3 text-warning"></i>
                        <span>{{ $sitePhone }}</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="fas fa-envelope me-3 text-warning"></i>
                        <span>{{ $siteEmail }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

    @auth
        @if(Auth::user()->role == 'user')
            <a href="{{ route('chat') }}" class="btn-chat-floating shadow-lg">
                <i class="fas fa-comment-dots fa-lg"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
                <span class="chat-label">Chat Admin</span>
            </a>

            <style>
                .btn-chat-floating {
                    position: fixed;
                    bottom: 30px;
                    right: 30px;
                    width: 60px;
                    height: 60px;
                    background-color: #25D366; /* Warna Hijau WA / Bisa ganti var(--primary-yellow) */
                    color: white;
                    border-radius: 50%;
                    text-align: center;
                    box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 9999; /* Agar selalu di atas elemen lain */
                    transition: all 0.3s ease;
                    text-decoration: none;
                }

                .btn-chat-floating i {
                    font-size: 28px;
                }

                /* Efek Hover: Membesar sedikit */
                .btn-chat-floating:hover {
                    transform: scale(1.1);
                    background-color: #128C7E;
                    color: white;
                }

                /* Label Teks (Opsional: muncul saat hover) */
                .chat-label {
                    display: none;
                    position: absolute;
                    right: 70px;
                    background: #333;
                    color: #fff;
                    padding: 5px 10px;
                    border-radius: 5px;
                    font-size: 12px;
                    white-space: nowrap;
                }
                
                .btn-chat-floating:hover .chat-label {
                    display: block;
                }
            </style>
        @endif
    @endauth
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>