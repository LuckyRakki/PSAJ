@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Produk</h2>
    <a href="{{ route('admin.products') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-12 mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label">Gambar Produk (Biarkan kosong jika tidak diganti)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <div class="mt-2">
                        <small>Gambar saat ini:</small><br>
                        @if(Str::startsWith($product->image, 'http'))
                            <img src="{{ $product->image }}" width="100" class="rounded border">
                        @else
                            <img src="{{ asset($product->image) }}" width="100" class="rounded border">
                        @endif
                    </div>
                </div>

                <!-- DYNAMIC SPECS -->
                <div class="col-12 mb-3">
                    <label class="form-label fw-bold">Spesifikasi Teknis</label>
                    <div id="specs-wrapper">
                        @if($product->specs)
                            @foreach($product->specs as $key => $value)
                            <div class="input-group mb-2">
                                <input type="text" name="spec_key[]" class="form-control" value="{{ $key }}">
                                <input type="text" name="spec_value[]" class="form-control" value="{{ $value }}">
                                <button type="button" class="btn btn-outline-danger remove-spec"><i class="fas fa-times"></i></button>
                            </div>
                            @endforeach
                        @else
                            <!-- Default jika kosong -->
                            <div class="input-group mb-2">
                                <input type="text" name="spec_key[]" class="form-control" placeholder="Label">
                                <input type="text" name="spec_value[]" class="form-control" placeholder="Nilai">
                                <button type="button" class="btn btn-outline-danger remove-spec"><i class="fas fa-times"></i></button>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-spec-btn">
                        <i class="fas fa-plus"></i> Tambah Spesifikasi
                    </button>
                </div>

            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-4">Update Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('specs-wrapper');
        const addBtn = document.getElementById('add-spec-btn');

        addBtn.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <input type="text" name="spec_key[]" class="form-control" placeholder="Label">
                <input type="text" name="spec_value[]" class="form-control" placeholder="Nilai">
                <button type="button" class="btn btn-outline-danger remove-spec"><i class="fas fa-times"></i></button>
            `;
            wrapper.appendChild(div);
        });

        wrapper.addEventListener('click', function(e) {
            if (e.target.closest('.remove-spec')) {
                e.target.closest('.input-group').remove();
            }
        });
    });
</script>
@endpush