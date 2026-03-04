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
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; overflow-x: hidden; }
        
        #wrapper { display: flex; width: 100%; transition: all 0.3s; }
        
        /* SIDEBAR STYLE */
        #sidebar-wrapper {
            min-width: 260px;
            max-width: 260px;
            background-color: #111827;
            color: #fff;
            min-height: 100vh;
            transition: all 0.3s;
        }
        #sidebar-wrapper .sidebar-heading { padding: 1.5rem; font-size: 1.25rem; font-weight: bold; border-bottom: 1px solid #374151; }
        #sidebar-wrapper .list-group-item {
            background-color: transparent;
            color: #9ca3af;
            border: none;
            padding: 1rem 1.5rem;
            font-weight: 500;
        }
        #sidebar-wrapper .list-group-item:hover { background-color: #1f2937; color: #fff; }
        #sidebar-wrapper .list-group-item.active { background-color: #2563eb; color: #fff; }
        
        /* CONTENT STYLE */
        #page-content-wrapper { width: 100%; }
        
        /* TOGGLED STATE */
        #wrapper.toggled #sidebar-wrapper { margin-left: -260px; }
        
        .navbar-admin { background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); padding: 15px 30px; }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading text-white py-4 px-3">
            <div class="d-flex align-items-center text-nowrap overflow-hidden">
                @if(isset($app_settings['site_logo']) && !empty($app_settings['site_logo']))
                    <!-- Flex-shrink-0 agar logo tidak gepeng -->
                    <img src="{{ asset($app_settings['site_logo']) }}" alt="Logo" style="height: 40px; width: auto;" class="me-2 flex-shrink-0 rounded">
                @else
                    <i class="fas fa-bolt text-warning me-2 fs-4 flex-shrink-0"></i> 
                @endif
                
                <!-- Text Truncate agar kalau kepanjangan jadi titik-titik (...) -->
                <span class="fs-5 fw-bold text-truncate" title="{{ $app_settings['site_name'] ?? 'Wiratama Admin' }}">
                    {{ $app_settings['site_name'] ?? 'Wiratama Admin' }}
                </span>
            </div>
        </div>
        <div class="list-group list-group-flush mt-3">
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-3" style="width:20px"></i> Dashboard
            </a>
            <a href="{{ route('admin.products') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                <i class="fas fa-box me-3" style="width:20px"></i> Produk
            </a>
            <a href="{{ route('admin.chat') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.chat*') ? 'active' : '' }}">
                <i class="fas fa-comments me-3" style="width:20px"></i> Live Chat
            </a>
            <a href="{{ route('admin.reports') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-3" style="width:20px"></i> Laporan & Histori
            </a>
            <a href="{{ route('admin.customers') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
                <i class="fas fa-users me-3" style="width:20px"></i> Kelola Customer
            </a>
            
            <a href="{{ route('admin.settings') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <i class="fas fa-cog me-3" style="width:20px"></i> Pengaturan
            </a>
            
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action text-danger mt-5">
                <i class="fas fa-sign-out-alt me-3" style="width:20px"></i> Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-admin d-flex justify-content-between">
            <button class="btn btn-outline-secondary" id="menu-toggle"><i class="fas fa-bars"></i></button>
            <div class="fw-bold text-secondary">Halo, {{ Auth::user()->name }}</div>
        </nav>

        <div class="container-fluid p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var el = document.getElementById("wrapper");
    var toggleButton = document.getElementById("menu-toggle");

    toggleButton.onclick = function () {
        el.classList.toggle("toggled");
    };
</script>
@stack('scripts')
</body>
</html>