<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Pastikan 'image' ditambahkan ke dalam array ini
    protected $fillable = ['name', 'image'];

    // Relasi ke Produk (sudah ada pastinya)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}