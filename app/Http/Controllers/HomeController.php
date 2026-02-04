<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Data produk genset (dummy data)
        $gensetProducts = [
            [
                'id' => 1,
                'name' => 'Genset Diesel 10 KVA',
                'description' => 'Genset diesel dengan kapasitas 10 KVA, cocok untuk acara kecil hingga menengah seperti pernikahan, pertemuan, atau syuting kecil.',
                'price_per_day' => 500000,
                'image' => 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'id' => 2,
                'name' => 'Genset Diesel 20 KVA',
                'description' => 'Genset diesel dengan kapasitas 20 KVA, ideal untuk acara menengah seperti konser kecil, festival, atau syuting film.',
                'price_per_day' => 800000,
                'image' => 'https://images.unsplash.com/photo-1563791441147-8b7f8c92c2aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'id' => 3,
                'name' => 'Genset Diesel 50 KVA',
                'description' => 'Genset diesel dengan kapasitas 50 KVA, untuk acara besar seperti konser, festival besar, atau event skala industri.',
                'price_per_day' => 1500000,
                'image' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ]
        ];

        // Data produk AC (dummy data)
        $acProducts = [
            [
                'id' => 1,
                'name' => 'AC Standing 2 PK',
                'description' => 'AC standing dengan kapasitas 2 PK, cocok untuk ruangan hingga 30 m². Dilengkapi remote control dan mode dingin cepat.',
                'price_per_day' => 150000,
                'image' => 'https://images.unsplash.com/photo-1569591159212-b1ea455b7810?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'id' => 2,
                'name' => 'AC Standing 3 PK',
                'description' => 'AC standing dengan kapasitas 3 PK, ideal untuk ruangan hingga 50 m². Sistem inverter untuk hemat energi.',
                'price_per_day' => 200000,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            [
                'id' => 3,
                'name' => 'AC Standing 5 PK',
                'description' => 'AC standing dengan kapasitas 5 PK, untuk ruangan besar hingga 80 m². Fitur canggih dan konsumsi daya efisien.',
                'price_per_day' => 300000,
                'image' => 'https://images.unsplash.com/photo-1569591159212-b1ea455b7810?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ]
        ];

        return view('home', compact('gensetProducts', 'acProducts'));
    }

    public function pricing()
    {
        $pricingPlans = [
            [
                'name' => 'Paket Harian',
                'description' => 'Sewa per hari, cocok untuk acara singkat',
                'price' => 'Mulai dari Rp 150.000/hari',
                'features' => [
                    'Minimum 1 hari sewa',
                    'Pengantaran dan penjemputan',
                    'Support teknis 24 jam',
                    'Unit terawat berkala'
                ]
            ],
            [
                'name' => 'Paket Mingguan',
                'description' => 'Sewa per minggu, lebih hemat untuk acara yang berlangsung beberapa hari',
                'price' => 'Mulai dari Rp 900.000/minggu',
                'features' => [
                    'Minimum 7 hari sewa',
                    'Diskon 15% dari harga harian',
                    'Pengantaran dan penjemputan gratis',
                    'Support teknis 24 jam',
                    'Unit terawat berkala',
                    'Gratis pemeriksaan tengah periode'
                ]
            ],
            [
                'name' => 'Paket Bulanan',
                'description' => 'Sewa per bulan, ideal untuk proyek jangka panjang',
                'price' => 'Mulai dari Rp 3.000.000/bulan',
                'features' => [
                    'Minimum 30 hari sewa',
                    'Diskon 30% dari harga harian',
                    'Pengantaran dan penjemputan gratis',
                    'Support teknis 24 jam',
                    'Unit terawat berkala',
                    'Gratis pemeriksaan berkala',
                    'Prioritas penggantian unit jika diperlukan'
                ]
            ]
        ];

        return view('pricing', compact('pricingPlans'));
    }

    public function productDetail($type, $id)
    {
        // Dummy data - dalam implementasi nyata akan query dari database
        $product = [
            'id' => $id,
            'type' => $type,
            'name' => $type == 'genset' ? 'Genset Diesel ' . ($id * 10) . ' KVA' : 'AC Standing ' . ($id + 1) . ' PK',
            'description' => $type == 'genset' 
                ? 'Genset diesel dengan kapasitas ' . ($id * 10) . ' KVA, cocok untuk berbagai keperluan acara. Dilengkapi dengan sistem pembuangan yang baik dan konsumsi bahan bakar yang efisien.' 
                : 'AC standing dengan kapasitas ' . ($id + 1) . ' PK, ideal untuk ruangan hingga ' . (($id + 1) * 15) . ' m². Dilengkapi dengan remote control, timer, dan mode hemat energi.',
            'specifications' => $type == 'genset' 
                ? [
                    ['name' => 'Kapasitas Daya', 'value' => ($id * 10) . ' KVA'],
                    ['name' => 'Tipe Mesin', 'value' => 'Diesel 4 Tak'],
                    ['name' => 'Kapasitas Tangki', 'value' => (($id * 10) * 2) . ' Liter'],
                    ['name' => 'Daya Maksimum', 'value' => ($id * 10 * 0.8) . ' KW'],
                    ['name' => 'Tingkat Kebisingan', 'value' => '75-80 dB'],
                    ['name' => 'Berat', 'value' => (($id * 10) * 20) . ' kg'],
                ]
                : [
                    ['name' => 'Capasitas', 'value' => ($id + 1) . ' PK'],
                    ['name' => 'Luas Ruangan', 'value' => (($id + 1) * 15) . ' m²'],
                    ['name' => 'Konsumsi Daya', 'value' => (($id + 1) * 800) . ' Watt'],
                    ['name' => 'Fitur', 'value' => 'Remote Control, Timer, Sleep Mode'],
                    ['name' => 'Tipe', 'value' => 'Inverter'],
                    ['name' => 'Garansi', 'value' => '1 Tahun Service'],
                ],
            'price_per_day' => $type == 'genset' ? ($id * 300000 + 200000) : ($id * 50000 + 100000),
            'image' => $type == 'genset' 
                ? 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                : 'https://images.unsplash.com/photo-1569591159212-b1ea455b7810?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
        ];

        return view('product-detail', compact('product'));
    }
}