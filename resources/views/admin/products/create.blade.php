@extends('layouts.admin')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h3 class="fw-bold">Tambah Produk</h3>
    <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary btn-sm">Batal</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Genset Silent 100kVA" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi Lengkap</label>
                        <textarea name="description" class="form-control" rows="5" required></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gambar Produk</label>
                        <div class="border rounded p-2 text-center bg-light mb-2" style="height: 200px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            <img id="img-preview" src="#" alt="Preview" style="display: none; max-height: 100%; max-width: 100%;">
                            <i id="img-icon" class="fas fa-image fa-3x text-secondary"></i>
                        </div>
                        <input type="file" name="image" id="img-input" class="form-control" accept="image/*" required>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="mb-4">
                <label class="form-label fw-bold"><i class="fas fa-list me-2"></i>Spesifikasi Teknis</label>
                <div id="specs-wrapper">
                    <div class="input-group mb-2">
                        <input type="text" name="spec_key[]" class="form-control" placeholder="Label (ex: Kapasitas)">
                        <input type="text" name="spec_value[]" class="form-control" placeholder="Nilai (ex: 40 kVA)">
                        <button type="button" class="btn btn-danger remove-spec"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add-spec-btn">
                    <i class="fas fa-plus me-1"></i> Baris Spesifikasi
                </button>
            </div>

            <button type="submit" class="btn btn-primary px-5">Simpan Produk</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Preview Gambar
    const imgInput = document.getElementById('img-input');
    const imgPreview = document.getElementById('img-preview');
    const imgIcon = document.getElementById('img-icon');

    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            imgPreview.src = URL.createObjectURL(file);
            imgPreview.style.display = 'block';
            imgIcon.style.display = 'none';
        }
    }

    // Dinamis Spek
    document.getElementById('add-spec-btn').addEventListener('click', () => {
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" name="spec_key[]" class="form-control" placeholder="Label">
            <input type="text" name="spec_value[]" class="form-control" placeholder="Nilai">
            <button type="button" class="btn btn-danger remove-spec"><i class="fas fa-trash"></i></button>`;
        document.getElementById('specs-wrapper').appendChild(div);
    });

    document.getElementById('specs-wrapper').addEventListener('click', (e) => {
        if (e.target.closest('.remove-spec')) e.target.closest('.input-group').remove();
    });
</script>
@endpush
@endsection