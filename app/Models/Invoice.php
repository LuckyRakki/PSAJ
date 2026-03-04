<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',
        'user_id',
        'title',
        'amount',
        'status', // pending, confirmed, paid, cancelled
        'nama_penyewa',
        'no_hp',
        'alamat_pengiriman',
        'tanggal_mulai',
        'durasi_sewa',
        'catatan',
        'snap_token'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}