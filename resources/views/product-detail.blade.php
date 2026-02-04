@extends('layouts.app')

@section('title', $product['name'] . ' - Wiratama Teknik')

@section('content')
    <section class="py-5">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home') }}#products">Produk</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product['name'] }}</li>
                </ol>
            </nav>
            
            <div class="row mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ $product['image'] }}" class="card-img-top" alt="{{ $product['name'] }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h1 class="h2 mb-3">{{ $product['name'] }}</h1>
                            <p class="lead mb-4">{{ $product['description'] }}</p>
                            
                            <div class="mb-4">
                                <h3 class="h4 text-primary">Rp {{ number_format($product['price_per_day'], 0, ',', '.') }} <small class="text-muted">/hari</small></h3>
                            </div>
                            
                            @auth
                            <div class="mb-4">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                    <input type="hidden" name="product_type" value="{{ $product['type'] }}">
                                    
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label for="duration" class="form-label">Durasi Sewa (hari)</label>
                                            <input type="number" class="form-control" id="duration" name="duration" value="1" min="1" max="30">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="quantity" class="form-label">Jumlah Unit</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="10">
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid gap-2 d-md-flex">
                                        <button type="submit" class="btn btn-primary btn-lg px-4">
                                            <i class="fas fa-cart-plus me-2"></i> Tambah ke Keranjang
                                        </button>
                                        <a href="{{ route('home') }}#products" class="btn btn-outline-primary btn-lg px-4">
                                            <i class="fas fa-arrow-left me-2"></i> Lihat Produk Lain
                                        </a>
                                    </div>
                                </form>
                            </div>
                            @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> Silakan <a href="{{ route('login') }}" class="alert-link">login</a> terlebih dahulu untuk melakukan pemesanan.
                            </div>
                            @endauth
                            
                            <div class="mt-4">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-truck text-primary me-3 fa-lg"></i>
                                    <div>
                                        <h6 class="mb-0">Pengantaran Gratis</h6>
                                        <small class="text-muted">Area Tangerang (biaya tambahan untuk luar area)</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-shield-alt text-primary me-3 fa-lg"></i>
                                    <div>
                                        <h6 class="mb-0">Garansi Unit</h6>
                                        <small class="text-muted">Garansi selama masa sewa</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-headset text-primary me-3 fa-lg"></i>
                                    <div>
                                        <h6 class="mb-0">Support 24/7</h6>
                                        <small class="text-muted">Dukungan teknis selama masa sewa</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h3 class="mb-4">Spesifikasi Teknis</h3>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tbody>
                                        @foreach($product['specifications'] as $spec)
                                        <tr>
                                            <th width="30%">{{ $spec['name'] }}</th>
                                            <td>{{ $spec['value'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    @if($product['type'] == 'genset')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="mb-4">Rekomendasi Penggunaan</h3>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-film fa-3x text-primary mb-3"></i>
                                    <h5>Syuting Film</h5>
                                    <p>Cocok untuk kebutuhan listrik peralatan kamera, lighting, dan peralatan produksi film lainnya.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-music fa-3x text-primary mb-3"></i>
                                    <h5>Konser & Event</h5>
                                    <p>Mampu menyalurkan daya untuk sound system, lighting panggung, dan peralatan pendukung event.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-utensils fa-3x text-primary mb-3"></i>
                                    <h5>Hajatan & Pernikahan</h5>
                                    <p>Untuk kebutuhan listrik tenda, penerangan, sound system, dan peralatan dapur selama acara.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const durationInput = document.getElementById('duration');
        const quantityInput = document.getElementById('quantity');
        
        if(durationInput && quantityInput) {
            function calculateTotal() {
                const duration = parseInt(durationInput.value) || 1;
                const quantity = parseInt(quantityInput.value) || 1;
                const pricePerDay = {{ $product['price_per_day'] }};
                const total = pricePerDay * duration * quantity;
                
                // Update tampilan harga (opsional)
                const priceElement = document.querySelector('.h4.text-primary');
                if(priceElement && duration > 1) {
                    priceElement.innerHTML = `Rp ${formatRupiah(pricePerDay)} <small class="text-muted">/hari</small><br>
                                             <small>Total untuk ${duration} hari (${quantity} unit): <strong>Rp ${formatRupiah(total)}</strong></small>`;
                }
            }
            
            function formatRupiah(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
            
            durationInput.addEventListener('change', calculateTotal);
            quantityInput.addEventListener('change', calculateTotal);
        }
    });
</script>
@endpush