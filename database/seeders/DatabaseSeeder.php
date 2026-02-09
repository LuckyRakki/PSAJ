<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil hanya seeder kustom yang kita buat.
        $this->call([
            ProductSeeder::class,
        ]);

        // Baris di bawah ini yang menyebabkan error, karena ia membuat user "Test User"
        // Kita komentari atau hapus saja karena kita sudah membuat user di ProductSeeder
        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}