<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kosongkan tabel (Reset)
        Product::query()->delete();
        Category::query()->delete();
        User::query()->whereNotIn('email', ['admin@wiratama.com', 'user@gmail.com'])->delete();

        // 2. Buat User jika belum ada
        User::firstOrCreate(
            ['email' => 'admin@wiratama.com'],
            ['name' => 'Admin Wiratama', 'username' => 'admin', 'password' => Hash::make('password'), 'role' => 'admin']
        );
        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            ['name' => 'User Biasa', 'username' => 'user', 'password' => Hash::make('password'), 'role' => 'user']
        );

        // 3. Buat Kategori dengan path gambar lokal
        // Pastikan file gambar ini ada di dalam folder public/images/
        $catGenset = Category::create(['name' => 'Genset', 'slug' => 'genset', 'image' => 'images/genset.png']);
        $catAC = Category::create(['name' => 'AC Standing', 'slug' => 'ac', 'image' => 'images/ac-standing.png']);
        $catFan = Category::create(['name' => 'Misty Fan', 'slug' => 'fan', 'image' => 'images/misty-fan.png']);
        $catTenda = Category::create(['name' => 'Tenda', 'slug' => 'tenda', 'image' => 'images/tenda.png']);

        // 4. Buat Produk menggunakan gambar lokal yang sesuai dengan kategorinya
        $products = [
            // Genset 
            ['category_id' => $catGenset->id, 'name' => 'Genset 40kVA', 'rental_count' => 15, 'image' => 'images/genset40.png', 'description' => 'Kapasitas 40kVA, cocok untuk acara kecil.', 'specs' => ['Kapasitas Daya' => '40kVA / 32 kW', 'Tegangan' => '380/400 Volt (3 Phase)']],
            ['category_id' => $catGenset->id, 'name' => 'Genset 60kVA', 'rental_count' => 25, 'image' => 'images/genset60.png', 'description' => 'Kapasitas 60kVA, handal untuk event menengah.', 'specs' => ['Kapasitas Daya' => '60kVA / 48 kW', 'Tegangan' => '380/400 Volt (3 Phase)']],
            ['category_id' => $catGenset->id, 'name' => 'Genset 100kVA', 'rental_count' => 40, 'image' => 'images/genset100.png', 'description' => 'Kapasitas 100kVA, performa tinggi untuk industri.', 'specs' => ['Kapasitas Daya' => '100kVA / 80 kW', 'Tegangan' => '380/400 Volt (3 Phase)']],
            ['category_id' => $catGenset->id, 'name' => 'Genset 150kVA', 'rental_count' => 18, 'image' => 'images/genset150.png', 'description' => 'Kapasitas 150kVA, power maksimal.', 'specs' => ['Kapasitas Daya' => '150kVA / 120 kW', 'Tegangan' => '380/400 Volt (3 Phase)']],
            
            // AC 
            ['category_id' => $catAC->id, 'name' => 'AC Standing', 'rental_count' => 55, 'image' => 'images/ac-standing.png', 'description' => 'Kapasitas 5PK, cocok untuk semua jenis acara.'],
            
            // Fan 
            ['category_id' => $catFan->id, 'name' => 'Misty Fan', 'rental_count' => 30, 'image' => 'images/misty-fan.png', 'description' => 'Kipas angin embun untuk acara outdoor.'],
            
            // Tenda 
            ['category_id' => $catTenda->id, 'name' => 'Tenda Sarnafil 5 x 5', 'rental_count' => 35, 'image' => 'images/tenda.png', 'description' => 'Ukuran 5x5 meter, untuk booth atau pameran.'],
            ['category_id' => $catTenda->id, 'name' => 'Tenda Sarnafil 3 x 3', 'rental_count' => 22, 'image' => 'images/tenda.png', 'description' => 'Ukuran 3x3 meter, praktis dan ringkas.'],
            ['category_id' => $catTenda->id, 'name' => 'Tenda Roder', 'rental_count' => 12, 'image' => 'images/tenda.png', 'description' => 'Ukuran besar, untuk gudang atau acara besar.'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}