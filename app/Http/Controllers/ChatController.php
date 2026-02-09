<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        // Cari admin (asumsi admin pertama yang ditemukan)
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return redirect()->route('home')->with('error', 'Maaf, Admin belum tersedia saat ini.');
        }

        // Ambil percakapan antara User yang login & Admin
        $messages = Message::where(function($q) use ($admin) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $admin->id);
        })->orWhere(function($q) use ($admin) {
            $q->where('sender_id', $admin->id)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return view('chat.index', compact('messages', 'admin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $admin->id, // Perbaikan sintaks di sini
                'message' => $request->message
            ]);
        }

        return back();
    }
}