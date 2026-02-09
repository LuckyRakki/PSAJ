<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Wiratama Teknik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar {
            min-height: 100vh;
            background-color: #0f2f57;
            color: white;
        }
        .sidebar a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            padding: 15px 20px;
            display: block;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #ffc107;
            color: #0f2f57;
            font-weight: bold;
        }
        .content { padding: 30px; }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar col-md-2 d-none d-md-block">
        <div class="p-3 text-center border-bottom border-secondary">
            <h5 class="mb-0 fw-bold text-white">Admin Panel</h5>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a href="{{ route('admin.products') }}" class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}">
            <i class="fas fa-box me-2"></i> Produk
        </a>
        <a href="{{ route('admin.chat') }}" class="{{ request()->routeIs('admin.chat*') ? 'active' : '' }}">
            <i class="fas fa-comments me-2"></i> Chat Pelanggan
            <span class="badge bg-warning text-dark ms-auto float-end" style="font-size: 0.7rem;">New</span>
        </a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger mt-5">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

    <!-- Main Content -->
    <div class="col-md-10 col-12">
        <!-- Top Navbar Mobile Toggle could go here -->
        <div class="content">
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
@stack('scripts')
</body>
</html>