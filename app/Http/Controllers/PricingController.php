<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class PricingController extends Controller
{
    public function index()
    {
        return response()->json([
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
                'description' => 'Lebih hemat untuk acara beberapa hari',
                'price' => 'Mulai dari Rp 900.000/minggu',
                'features' => [
                    'Minimum 7 hari sewa',
                    'Diskon 15%',
                    'Gratis antar jemput',
                    'Support 24 jam'
                ]
            ],
            [
                'name' => 'Paket Bulanan',
                'description' => 'Ideal proyek jangka panjang',
                'price' => 'Mulai dari Rp 3.000.000/bulan',
                'features' => [
                    'Minimum 30 hari',
                    'Diskon 30%',
                    'Prioritas unit'
                ]
            ]
        ]);
    }
}
