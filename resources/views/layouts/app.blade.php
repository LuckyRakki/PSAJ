<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Wiratama Teknik - Penyewaan Genset dan AC Standing di Tangerang">
    <title>@yield('title', 'Wiratama Teknik - Sewa Genset & AC Standing')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --accent-color: #3498db;
            --light-color: #f8f9fa;
            --dark-color: #2c3e50;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            padding-top: 76px;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        
        .nav-link {
            font-weight: 500;
            margin: 0 5px;
        }
        
        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-primary:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }
        
        .hero-section {
            background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.8)), url('https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 50px;
            color: var(--primary-color);
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -10px;
            width: 60px;
            height: 3px;
            background-color: var(--secondary-color);
        }
        
        .product-card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            border: 1px solid #eee;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .product-img {
            height: 200px;
            object-fit: cover;
        }
        
        .feature-icon {
            font-size: 40px;
            color: var(--secondary-color);
            margin-bottom: 15px;
        }
        
        footer {
            background-color: var(--primary-color);
            color: white;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-tools"></i> Wiratama Teknik
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#products">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pricing') }}">Harga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#contact">Kontak</a>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('cart') }}"><i class="fas fa-shopping-cart"></i> Keranjang</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-history"></i> Riwayat Pesanan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Wiratama Teknik</h5>
                    <p>Penyewaan Genset dan AC Standing terpercaya di Tangerang. Melayani kebutuhan syuting, konser, hajatan, dan acara lainnya.</p>
                    <div class="social-icons mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-whatsapp fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Kontak Kami</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Tangerang, Banten</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +62 812-3456-7890</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@wiratamateknik.com</li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Jam Operasional</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">Senin - Jumat: 08:00 - 17:00</li>
                        <li class="mb-2">Sabtu: 08:00 - 15:00</li>
                        <li class="mb-2">Minggu & Hari Besar: Tutup</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Wiratama Teknik. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scroll untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if(targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>