@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0 text-dark">Manajemen Produk</h3>
        <p class="text-muted mb-0 small">Kelola katalog alat teknik dan barang sewaan Anda.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4 fw-bold" style="background-color: #0f2f57; border: none;">
        <i class="fas fa-plus me-2"></i> Tambah Produk Baru
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-4 py-3">Info Produk</th>
                        <th class="py-3">Kategori</th>
                        <th class="text-center py-3">Total Disewa</th>
                        <th class="text-end pe-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-white border rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; overflow: hidden;">
                                    @if(Str::startsWith($product->image, 'http'))
                                        <img src="{{ $product->image }}" style="width: 100%; height: 100%; object-fit: cover;" alt="Gambar">
                                    @else
                                        <img src="{{ asset($product->image) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="Gambar">
                                    @endif
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">{{ $product->name }}</h6>
                                    <small class="text-muted text-truncate d-inline-block" style="max-width: 200px;">
                                        ID: #PRD-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <span class="badge bg-light text-primary border px-2 py-1">
                                <i class="fas fa-tag me-1 text-muted"></i> {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="text-center py-3">
                            <div class="fw-bold text-dark">{{ $product->rental_count }}x</div>
                        </td>
                        <td class="text-end pe-4 py-3">
                            <div class="btn-group shadow-sm rounded-3">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-light border text-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini secara permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-light border text-danger" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted opacity-25 mb-3"></i>
                            <h6 class="text-dark fw-bold">Belum ada produk</h6>
                            <p class="text-muted small">Silakan tambah produk pertama Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end mt-4">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
@endsection