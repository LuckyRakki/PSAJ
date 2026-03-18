@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0 text-dark">Kategori Produk</h3>
        <p class="text-muted mb-0 small">Kelola jenis kategori penyewaan Anda.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4 fw-bold" style="background-color: #0f2f57; border: none;">
        <i class="fas fa-plus me-2"></i> Tambah Kategori
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted" style="font-size: 0.85rem; text-transform: uppercase;">
                    <tr>
                        <th class="ps-4 py-3">Nama & Ikon</th>
                        <th class="py-3 text-center">Jumlah Produk</th>
                        <th class="text-end pe-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-white border rounded-3 d-flex align-items-center justify-content-center me-3 p-1" style="width: 60px; height: 60px;">
                                    @if(!empty($cat->image))
                                        <img src="{{ Str::startsWith($cat->image, 'http') ? $cat->image : asset($cat->image) }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    @else
                                        <i class="fas fa-tags text-muted fa-2x opacity-50"></i>
                                    @endif
                                </div>
                                <h6 class="fw-bold text-dark mb-0">{{ $cat->name }}</h6>
                            </div>
                        </td>
                        <td class="text-center py-3">
                            <span class="badge bg-primary rounded-pill px-3">{{ $cat->products_count }} Produk</span>
                        </td>
                        <td class="text-end pe-4 py-3">
                            <div class="btn-group shadow-sm rounded-3">
                                <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-sm btn-light border text-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                        <td colspan="3" class="text-center py-5 text-muted">Belum ada kategori.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection