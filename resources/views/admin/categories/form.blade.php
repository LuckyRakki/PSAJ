@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0 text-dark">{{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h3>
    <a href="{{ route('admin.categories') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">
        <form action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($category)) @method('PUT') @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required placeholder="Contoh: Genset Silent">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Ikon / Gambar Kategori</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted d-block mt-1">Format: JPG, PNG, SVG (Maks. 2MB). Gunakan background transparan (PNG/SVG) untuk hasil terbaik.</small>
                    
                    @if(isset($category) && !empty($category->image))
                        <div class="mt-2 p-2 border rounded bg-light d-inline-block">
                            <img src="{{ Str::startsWith($category->image, 'http') ? $category->image : asset($category->image) }}" height="50">
                        </div>
                    @endif
                </div>
            </div>

            <hr class="opacity-25 my-4">
            
            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill" style="background-color: #0f2f57; border: none;">
                <i class="fas fa-save me-2"></i> {{ isset($category) ? 'Simpan Perubahan' : 'Simpan Kategori' }}
            </button>
        </form>
    </div>
</div>
@endsection