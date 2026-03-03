<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Invoice; // Tambahkan Model Invoice
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
    {
        $admin = User::where('role', 'admin')->first();
        if (!$admin) return redirect()->route('home')->with('error', 'Admin tidak tersedia.');

        // Ambil Pesan
        $messages = Message::where(function($q) use ($admin) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $admin->id);
        })->orWhere(function($q) use ($admin) {
            $q->where('sender_id', $admin->id)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        $invoices = \App\Models\Invoice::where('user_id', \Illuminate\Support\Facades\Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

        return view('chat.index', compact('messages', 'admin', 'invoices'));
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

        $invoice->update([
            'nama_penyewa' => $request->nama_penyewa,
            'no_hp' => $request->no_hp,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'tanggal_mulai' => $request->tanggal_mulai,
            'durasi_sewa' => $request->durasi_sewa,
            'catatan' => $request->catatan,
            'status' => 'confirmed' // Status berubah jadi confirmed
        ]);

        return redirect()->route('invoice.payment', $id);
    }
    public function showPayment($id)
    {
        $invoice = Invoice::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Jika status masih pending (belum isi alamat), lempar ke form confirm dulu
        if ($invoice->status == 'pending') {
            return redirect()->route('invoice.confirm', $id);
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
}