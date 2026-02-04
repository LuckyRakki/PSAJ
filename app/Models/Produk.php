<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'produk_id';
    protected $fillable = [
        'kategori_id','nama','harga','stok','deskripsi','status_produk'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
