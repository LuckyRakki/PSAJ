<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Invoice; // Tambahkan Model Invoice
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Midtrans\Config;
use Midtrans\Snap;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Message::where('sender_id', Auth::id())
                           ->orWhere('receiver_id', Auth::id())
                           ->orderBy('created_at', 'asc')
                           ->get();

        // Tampilkan hanya tagihan Lunas ATAU yang umurnya kurang dari 24 jam
        $invoices = Invoice::where('user_id', Auth::id())
                           ->where(function($query) {
                               $query->where('status', 'paid')
                                     ->orWhere('created_at', '>=', now()->subHours(24));
                           })
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('chat.index', compact('messages', 'invoices'));
    }

    public function store(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $admin->id,
                'message' => $request->message,
                'is_read' => false // Default belum dibaca
            ]);
        }
        return back();
    }

    public function sendProductMessage($id)
    {
        $product = \App\Models\Product::with('category')->findOrFail($id);
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return redirect()->back()->with('error', 'Admin tidak tersedia saat ini.');
        }

        // KITA UBAH FORMATNYA MENJADI KODE UNIK DENGAN PEMISAH GARIS LURUS (|)
        // Format: [PRODUCT_CARD]|ID|Nama|Kategori|Gambar
        $templateMessage = "[PRODUCT_CARD]|{$product->id}|{$product->name}|{$product->category->name}|{$product->image}";

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $admin->id,
            'message' => $templateMessage,
            'is_read' => false
        ]);

        return redirect()->route('chat')->with('success', 'Permintaan sewa terkirim! Silakan tunggu balasan dari Admin.');
    }

    public function showConfirmForm($id)
    {
        $invoice = Invoice::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($invoice->status != 'pending') {
            return redirect()->route('chat')->with('error', 'Tagihan ini sudah diproses.');
        }

        return view('chat.confirm', compact('invoice'));
    }

    public function processConfirm(Request $request, $id)
    {
        $invoice = Invoice::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'nama_penyewa' => 'required',
            'no_hp' => 'required',
            'alamat_pengiriman' => 'required',
            'tanggal_mulai' => 'required|date',
            'durasi_sewa' => 'required|integer|min:1',
        ]);

        $durasi = $request->durasi_sewa;
        $totalHargaFinal = $invoice->amount * $durasi;

        $invoice->update([
            'nama_penyewa' => $request->nama_penyewa,
            'no_hp' => $request->no_hp,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'tanggal_mulai' => $request->tanggal_mulai,
            'durasi_sewa' => $durasi,
            'catatan' => $request->catatan,
            
            'amount' => $totalHargaFinal, // <-- PENTING: Update harga akhirnya di sini
            'status' => 'confirmed'
        ]);

        return redirect()->route('invoice.payment', $id);
    }
    public function showPayment($id)
    {
        $invoice = \App\Models\Invoice::where('id', $id)->where('user_id', \Illuminate\Support\Facades\Auth::id())->firstOrFail();

        // 1. Konfigurasi Midtrans (Ambil dari Config)
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // 2. Cek Token
        if (empty($invoice->snap_token)) {
            
            // Buat Order ID unik
            $orderId = $invoice->invoice_code . '-' . time();

            // FIX: Pastikan Harga adalah INTEGER BULAT
            $grossAmount = (int) round($invoice->amount);

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $grossAmount, 
                ],
                'customer_details' => [
                    'first_name' => $invoice->nama_penyewa,
                    'email' => \Illuminate\Support\Facades\Auth::user()->email,
                    'phone' => $invoice->no_hp ?? '08123456789',
                ],
                'item_details' => [
                    [
                        'id' => $invoice->id,
                        'price' => $grossAmount, // FIX: HARUS INTEGER
                        'quantity' => 1,
                        'name' => substr($invoice->title, 0, 49) // Limit nama barang
                    ]
                ]
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                
                // Simpan ke database
                $invoice->snap_token = $snapToken;
                $invoice->save();
                
            } catch (\Exception $e) {
                // DEBUGGING: Matikan redirect loop, tampilkan error aslinya
                dd('Midtrans Error: ' . $e->getMessage()); 
            }
        }

        return view('chat.payment', compact('invoice'));
    }

    public function processPayment(Request $request, $id)
    {
        $invoice = \App\Models\Invoice::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '_' . $invoice->invoice_code . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke: public/uploads/payments
            $file->move(public_path('uploads/payments'), $filename);
            
            // Simpan ke DB hanya: uploads/payments/namafile.jpg
            $dbPath = 'uploads/payments/' . $filename;

            $invoice->update([
                'payment_proof' => $dbPath,
                'status' => 'waiting_verification'
            ]);

            // Kirim pesan chat otomatis
            \App\Models\Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => \App\Models\User::where('role', 'admin')->first()->id,
                'message' => "Saya sudah upload bukti transfer untuk tagihan **#{$invoice->invoice_code}**. Mohon dicek.",
                'is_read' => false
            ]);
        }

        return redirect()->route('chat')->with('success', 'Bukti pembayaran berhasil dikirim!');
    }

    public function midtransCallback(Request $request)
    {
        // Kunci rahasia server kamu (Pastikan ada di file .env)
        $serverKey = config('services.midtrans.server_key');
        
        // Midtrans mengirimkan data, kita buat kuncinya untuk dicocokkan
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        // Jika kuncinya cocok (berarti valid dari Midtrans, bukan hacker)
        if ($hashed == $request->signature_key) {
            
            // Cari tagihan berdasarkan order_id (biasanya menggunakan invoice_code)
            $invoice = \App\Models\Invoice::where('invoice_code', $request->order_id)->first();
            
            if ($invoice) {
                // Jika pembayaran Sukses (Settlement / Capture)
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $invoice->update(['status' => 'paid']);
                    
                    // (Opsional) Kirim notifikasi chat ke user otomatis dari sistem
                    \App\Models\Message::create([
                        'sender_id' => \App\Models\User::where('role', 'admin')->first()->id,
                        'receiver_id' => $invoice->user_id,
                        'message' => "Pembayaran untuk tagihan **{$invoice->invoice_code}** telah kami terima. Status pesanan Anda sekarang LUNAS dan akan segera kami proses.",
                        'is_read' => false
                    ]);
                } 
                // Jika pembayaran Kedaluwarsa / Batal (Expire / Cancel)
                elseif ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel') {
                    $invoice->update(['status' => 'pending']); // Atau bisa ubah jadi 'failed' / 'expired'
                }
            }
        }
        
        // Wajib balas 200 OK ke Midtrans agar mereka tidak mengirim notifikasi berulang-ulang
        return response()->json(['message' => 'Callback received']);
    }
}