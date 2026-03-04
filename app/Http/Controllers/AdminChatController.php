<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminChatController extends Controller
{
    // Halaman List Chat
    public function index()
    {
        // Ambil user yang pernah chat, urutkan dari yang terbaru
        $users = User::where('role', 'user')
            ->whereHas('sentMessages') // Hanya user yang pernah kirim pesan
            ->withCount(['sentMessages as unread' => function($q) {
                $q->where('is_read', false)->where('receiver_id', Auth::id());
            }])
            ->get();

        return view('admin.chat.index', compact('users'));
    }

    // Halaman Detail Chat dengan User Tertentu
    public function show($id)
    {
        $currentUser = User::findOrFail($id);
        
        // MARK AS READ: Update pesan dari user ini jadi 'read'
        Message::where('sender_id', $id)
               ->where('receiver_id', Auth::id())
               ->update(['is_read' => true]);

        // Ambil pesan
        $messages = Message::where(function($q) use ($id) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('sender_id', $id)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        // List User untuk sidebar
        $users = User::where('role', 'user')->withCount(['sentMessages as unread' => function($q) {
            $q->where('is_read', false)->where('receiver_id', Auth::id());
        }])->get();

        return view('admin.chat.index', compact('users', 'currentUser', 'messages'));
    }

    // Balas Pesan
    public function reply(Request $request, $id)
    {
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $id,
            'message' => $request->message
        ]);
        return back();
    }

    // GENERATE INVOICE (Fitur Baru)
    public function createInvoice(Request $request, $userId)
    {
        $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric'
        ]);

        $invoice = Invoice::create([
            'invoice_code' => 'INV-' . strtoupper(Str::random(6)),
            'user_id' => $userId,
            'title' => $request->title,
            'amount' => $request->amount,
            'status' => 'pending'
        ]);

        // Kirim pesan otomatis ke user bahwa invoice telah dibuat
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'message' => "TAGIHAN BARU DIBUAT: {$request->title} senilai Rp " . number_format($request->amount) . ". Silakan cek tombol 'Bayar' di atas chat.",
            'is_read' => false
        ]);

        return back()->with('success', 'Invoice berhasil dibuat!');
    }
}