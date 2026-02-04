<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Transaksi, DetailTransaksi};
use Illuminate\Http\Request;
use DB;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $transaksi = Transaksi::create([
                'user_id' => $request->user_id,
                'tanggal_transaksi' => now(),
                'tanggal_mulai_sewa' => $request->tanggal_mulai_sewa,
                'tanggal_selesai_sewa' => $request->tanggal_selesai_sewa,
                'nama_penerima' => $request->nama_penerima,
                'no_telepon' => $request->no_telepon,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'total_harga' => 0,
                'status_transaksi' => 'pending'
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                $subtotal = $item['jumlah'] * $item['harga_sewa'];

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->transaksi_id,
                    'produk_id' => $item['produk_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_sewa' => $item['harga_sewa'],
                    'subtotal' => $subtotal
                ]);

                $total += $subtotal;
            }

            $transaksi->update(['total_harga' => $total]);
        });

        return response()->json(['message' => 'Transaksi berhasil']);
    }
}
