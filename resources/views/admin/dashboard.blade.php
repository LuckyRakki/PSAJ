@extends('layouts.admin')

@section('content')
<h2 class="mb-4">Dashboard Overview</h2>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Produk</h6>
                        <h2 class="fw-bold my-2">{{ $totalProducts }}</h2>
                    </div>
                    <i class="fas fa-box fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Kategori</h6>
                        <h2 class="fw-bold my-2">{{ $totalCategories }}</h2>
                    </div>
                    <i class="fas fa-tags fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-warning text-dark h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Pelanggan Terdaftar</h6>
                        <h2 class="fw-bold my-2">{{ $totalUsers }}</h2>
                    </div>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection