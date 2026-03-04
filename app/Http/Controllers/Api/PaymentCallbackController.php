<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentCallbackController extends Controller
{
    public function handle(Request $request)
    {
        // GUNAKAN CONFIG, JANGAN ENV LANGSUNG
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            return response(['message' => 'Notification Error: ' . $e->getMessage()], 500);
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        // Cari Invoice berdasarkan Order ID
        // Karena di ChatController kita buat format: "INV-XXX-TIMESTAMP"
        // Kita cari invoice yang kodenya cocok dengan bagian depannya
        
        // Logika pencarian yang lebih aman:
        // Ambil bagian depan sebelum tanda strip terakhir (jika ada timestamp)
        // Atau cari berdasarkan snap_token jika Anda menyimpannya (opsional)
        
        // Asumsi format order_id: INV-CODE-RANDOM
        $parts = explode('-', $order_id);
        // Gabungkan kembali INV dan CODE (index 0 dan 1)
        $invoiceCode = $parts[0] . '-' . $parts[1]; 
        
        $invoice = Invoice::where('invoice_code', $invoiceCode)->first();
        
        if (!$invoice) {
            return response(['message' => 'Invoice not found'], 404);
        }

        // Hindari update status jika sudah paid
        if ($invoice->status == 'paid') {
            return response(['message' => 'Already paid'], 200);
        }

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $invoice->update(['status' => 'pending']);
                } else {
                    $invoice->update(['status' => 'paid']);
                }
            }
        } else if ($transaction == 'settlement') {
            // SETTLEMENT = LUNAS
            $invoice->update(['status' => 'paid']);
            
            // Kirim Notifikasi Chat ke Admin
            // Cek dulu apakah pesan sudah pernah dikirim agar tidak spam
            $exists = Message::where('message', 'like', "%Pembayaran otomatis via Midtrans BERHASIL%")
                             ->where('sender_id', $invoice->user_id)
                             ->exists();

            if (!$exists) {
                // Cari Admin
                $admin = User::where('role', 'admin')->first();
                if ($admin) {
                    Message::create([
                        'sender_id' => $invoice->user_id,
                        'receiver_id' => $admin->id,
                        'message' => "Pembayaran otomatis via Midtrans BERHASIL untuk invoice **#{$invoice->invoice_code}**",
                        'is_read' => false
                    ]);
                }
            }

        } else if ($transaction == 'pending') {
            $invoice->update(['status' => 'pending']);
        } else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
            $invoice->update(['status' => 'cancelled']);
        }

        return response(['message' => 'Success'], 200);
    }
}