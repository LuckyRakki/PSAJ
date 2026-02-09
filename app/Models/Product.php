<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'specs' => 'array', // Agar JSON otomatis jadi Array saat dipanggil
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}