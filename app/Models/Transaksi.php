<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'transaksi_id';
    protected $fillable = [
        'user_id','tanggal_transaksi','tanggal_mulai_sewa',
        'tanggal_selesai_sewa','nama_penerima','no_telepon',
        'alamat_pengiriman','total_harga','status_transaksi'
    ];

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'transaksi_id');
    }
}
