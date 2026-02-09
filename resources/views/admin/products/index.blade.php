@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manajemen Produk</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Tambah Produk
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Rental Count</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <!-- Cek apakah gambar dari URL external atau Upload lokal -->
                            @if(Str::startsWith($product->image, 'http'))
                                <img src="{{ $product->image }}" width="50" class="rounded">
                            @else
                                <img src="{{ asset($product->image) }}" width="50" class="rounded">
                            @endif
                        </td>
                        <td class="fw-bold">{{ $product->name }}</td>
                        <td><span class="badge bg-secondary">{{ $product->category->name }}</span></td>
                        <td>{{ $product->rental_count }}x</td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning text-white me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection