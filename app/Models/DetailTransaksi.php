<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'detail_id';
    protected $fillable = [
        'produk_id','transaksi_id','jumlah','harga_sewa','subtotal'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
