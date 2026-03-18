<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Wiratama Teknik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; overflow-x: hidden; }
        
        #wrapper { display: flex; width: 100%; min-height: 100vh; }

        #sidebar-wrapper {
            width: 260px;
            min-width: 260px;
            background-color: #0f2f57; 
            color: #fff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
            z-index: 10;

            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto; 
        }

        #sidebar-wrapper::-webkit-scrollbar {
            width: 5px;
        }
        #sidebar-wrapper::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
        #sidebar-wrapper .sidebar-heading { 
            padding: 1.5rem; 
            font-size: 1.25rem; 
            font-weight: bold; 
            border-bottom: 1px solid rgba(255,255,255,0.1); 
        }
        #sidebar-wrapper .list-group-item {
            background-color: transparent;
            color: #cbd5e1;
            border: none;
            padding: 1rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        #sidebar-wrapper .list-group-item:hover { 
            background-color: rgba(255,255,255,0.05); 
            color: #fff; 
            padding-left: 1.8rem; /* Efek geser dikit pas di hover */
        }
        #sidebar-wrapper .list-group-item.active { 
            background-color: #ffc107; /* Warna aksen kuning */
            color: #0f2f57; 
            font-weight: 700;
            border-radius: 0 30px 30px 0;
            margin-right: 15px;
        }
        
        /* CONTENT STYLE */
        #page-content-wrapper { flex-grow: 1; min-width: 0; background-color: #f1f5f9; }
        
        .navbar-admin { 
            background: white; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.05); 
            padding: 15px 30px; 
            border-bottom: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">
    <div id="sidebar-wrapper">
        <div class="sidebar-heading text-white py-4 px-3">
            <div class="d-flex align-items-center text-nowrap overflow-hidden">
                @if(isset($app_settings['site_logo']) && !empty($app_settings['site_logo']))
                    <img src="{{ asset($app_settings['site_logo']) }}" alt="Logo" style="height: 40px; width: auto;" class="me-2 flex-shrink-0 rounded">
                @else
                    <i class="fas fa-bolt text-warning me-2 fs-4 flex-shrink-0"></i> 
                @endif
                <span class="fs-5 fw-bold text-truncate" title="{{ $app_settings['site_name'] ?? 'Wiratama Admin' }}">
                    {{ $app_settings['site_name'] ?? 'Wiratama Admin' }}
                </span>
            </div>
        </div>
        
        <div class="list-group list-group-flush mt-3 flex-grow-1">
            <div class="px-3 mb-2 small fw-bold text-uppercase opacity-50 text-white" style="letter-spacing: 1px;">Menu Utama</div>
            
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-3" style="width:20px"></i> Dashboard
            </a>
            <a href="{{ route('admin.products') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                <i class="fas fa-box me-3" style="width:20px"></i> Produk
            </a>
            <a href="{{ route('admin.categories') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <i class="fas fa-tags me-3" style="width:20px"></i> Kategori
            </a>
            <a href="{{ route('admin.chat') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.chat*') ? 'active' : '' }}">
                <i class="fas fa-comments me-3" style="width:20px"></i> Chat Respon
            </a>
            <a href="{{ route('admin.reports') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-3" style="width:20px"></i> Laporan
            </a>
            <a href="{{ route('admin.customers') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
                <i class="fas fa-users me-3" style="width:20px"></i> Pelanggan
            </a>
            
            <div class="px-3 mt-4 mb-2 small fw-bold text-uppercase opacity-50 text-white" style="letter-spacing: 1px;">Sistem</div>
            <a href="{{ route('admin.settings') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <i class="fas fa-cog me-3" style="width:20px"></i> Pengaturan
            </a>
        </div>
        
        <div class="p-3 border-top" style="border-color: rgba(255,255,255,0.1) !important;">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger w-100 fw-bold shadow-sm">
                <i class="fas fa-sign-out-alt me-2"></i> Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>

    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-admin d-flex justify-content-end align-items-center">
            <div class="fw-bold text-dark d-flex align-items-center">
                <div class="me-3 text-end d-none d-md-block">
                    <div class="small fw-bold">{{ Auth::user()->name }}</div>
                    <div class="small text-muted" style="font-size: 0.7rem;">Administrator</div>
                </div>
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 1.2rem;">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </nav>

        <div class="container-fluid p-4">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle fs-4 me-3 text-success"></i>
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-triangle fs-4 me-3 text-danger"></i>
                    <div>
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Auto-hide alert script
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";
                setTimeout(function() { alert.remove(); }, 500);
            }, 3000); 
        });
    });
</script>
@stack('scripts')
</body>
</html>