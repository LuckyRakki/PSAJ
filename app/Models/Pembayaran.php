<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'pembayaran_id';
    protected $fillable = [
        'transaksi_id','bukti_pembayaran',
        'status_pembayaran','tanggal_pembayaran'
    ];
}
