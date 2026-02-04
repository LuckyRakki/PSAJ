@extends('layouts.app')

@section('title', 'Harga Sewa - Wiratama Teknik')

@section('content')
    <section class="py-5 hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-5 fw-bold mb-3">Harga Sewa Genset & AC Standing</h1>
                    <p class="lead mb-4">Pilih paket sewa yang sesuai dengan kebutuhan acara Anda. Harga transparan dan kompetitif dengan kualitas terjamin.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <h2 class="section-title">Paket Penyewaan</h2>
                    <p class="lead">Kami menawarkan berbagai pilihan paket sewa untuk memudahkan perencanaan anggaran Anda</p>
                </div>
            </div>
            
            <div class="row">
                @foreach($pricingPlans as $plan)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header bg-primary text-white text-center py-4">
                            <h4 class="my-0 fw-normal">{{ $plan['name'] }}</h4>
                        </div>
                        <div class="card-body text-center">
                            <h1 class="card-title pricing-card-title text-primary">{{ $plan['price'] }}</h1>
                            <p class="mb-4">{{ $plan['description'] }}</p>
                            <ul class="list-unstyled mb-4">
                                @foreach($plan['features'] as $feature)
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> {{ $feature }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('home') }}#products" class="btn btn-primary btn-lg px-4">Pilih Paket</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card border-0 shadow">
                        <div class="card-body p-5">
                            <h3 class="mb-4">Informasi Tambahan</h3>
                            <div class="accordion" id="pricingAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                            Apa saja yang termasuk dalam harga sewa?
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            Harga sewa sudah termasuk pengantaran dan penjemputan unit dalam area Tangerang, support teknis selama masa sewa, serta bahan bakar awal untuk genset. Untuk area di luar Tangerang, dikenakan biaya transportasi tambahan.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                            Apakah ada biaya tambahan?
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            Biaya tambahan dapat dikenakan jika terdapat kerusakan pada unit selama masa sewa yang disebabkan oleh penggunaan yang tidak sesuai atau kelalaian penyewa. Selain itu, untuk penggunaan bahan bakar genset setelah habis dari tangki awal, akan dikenakan biaya sesuai harga pasaran.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                            Bagaimana cara pemesanan?
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            Anda dapat memesan melalui website dengan membuat akun terlebih dahulu, kemudian memilih produk yang ingin disewa, menentukan durasi sewa, dan melakukan pembayaran. Alternatif lain, Anda dapat menghubungi kami langsung via WhatsApp atau telepon untuk konsultasi dan pemesanan.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection