<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ProdukController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'ok',
            'data' => [
                [
                    'id' => 1,
                    'kategori' => 'genset',
                    'name' => 'Genset Diesel 10 KVA',
                    'description' => 'Cocok untuk acara kecil',
                    'price_per_day' => 500000,
                    'image' => 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4'
                ],
                [
                    'id' => 2,
                    'kategori' => 'ac',
                    'name' => 'AC Standing 3 PK',
                    'description' => 'Untuk ruangan besar',
                    'price_per_day' => 200000,
                    'image' => 'https://images.unsplash.com/photo-1569591159212-b1ea455b7810'
                ]
            ]
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'status' => 'ok',
            'data' => [
                'id' => $id,
                'type' => 'genset',
                'name' => 'Genset Diesel 10 KVA',
                'description' => 'Deskripsi lengkap',
                'price_per_day' => 500000,
                'image' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12',
                'specifications' => [
                    ['name' => 'Daya', 'value' => '10 KVA']
                ]
            ]
        ]);
    }
}
