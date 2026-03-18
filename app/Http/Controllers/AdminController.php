<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Message;
use App\Models\Invoice;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // 1. Dashboard Utama
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::where('role', 'user')->count();
        $recentInvoices = Invoice::with('user')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalProducts', 'totalCategories', 'totalUsers', 'recentInvoices'));
    }

    // 2. List Produk
    public function products()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // 3. Form Tambah Produk
    public function productCreate()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // 4. Proses Simpan Produk
    public function productStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload Image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = 'uploads/products/' . $filename; // Path untuk disimpan di DB
        }

        // Proses Spesifikasi (Array to JSON)
        $specs = [];
        if ($request->has('spec_key')) {
            foreach ($request->spec_key as $index => $key) {
                if (!empty($key) && !empty($request->spec_value[$index])) {
                    $specs[$key] = $request->spec_value[$index];
                }
            }
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath, // Simpan path gambar
            'specs' => !empty($specs) ? $specs : null,
            'rental_count' => 0
        ]);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan');
    }

    // 5. Form Edit Produk
    public function productEdit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // 6. Proses Update Produk
    public function productUpdate(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
        ];

        // Cek jika ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika perlu (opsional)
            // if(file_exists(public_path($product->image))) unlink(public_path($product->image));

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $data['image'] = 'uploads/products/' . $filename;
        }

        // Proses Spesifikasi Baru
        $specs = [];
        if ($request->has('spec_key')) {
            foreach ($request->spec_key as $index => $key) {
                if (!empty($key)) {
                    $specs[$key] = $request->spec_value[$index] ?? '';
                }
            }
        }
        $data['specs'] = !empty($specs) ? $specs : null;

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui');
    }

    // 7. Hapus Produk
    public function productDestroy($id)
    {
        $product = Product::findOrFail($id);
        // Hapus file gambar jika ada
        if (file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        $product->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus');
    }

    public function chat($user_id = null)
    {
        $users = User::where('role', 'user')
            ->whereHas('sentMessages') // Ambil user yang pernah kirim pesan
            ->orWhereHas('receivedMessages')
            ->withCount(['sentMessages as unread' => function($q) {
                $q->where('receiver_id', Auth::id())->where('is_read', false);
            }])
            ->get();

        $messages = [];
        $currentUser = null;

        if ($user_id) {
            $currentUser = User::findOrFail($user_id);
            
            Message::where('sender_id', $user_id)
                   ->where('receiver_id', Auth::id())
                   ->update(['is_read' => true]);

            $messages = Message::where(function($q) use ($user_id) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $user_id);
            })->orWhere(function($q) use ($user_id) {
                $q->where('sender_id', $user_id)->where('receiver_id', Auth::id());
            })->orderBy('created_at', 'asc')->get();
        }

        $products = \App\Models\Product::all();

        return view('admin.chat.index', compact('users', 'messages', 'currentUser', 'products'));
    }

    public function chatReply(Request $request, $user_id)
    {
        $request->validate(['message' => 'required|string']);
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user_id,
            'message' => $request->message,
            'is_read' => false 
        ]);
        return back();
    }

    // Method Baru: Buat Invoice
    public function createInvoice(Request $request, $user_id)
    {
        $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        // 1. Buat Invoice di Database
        $invoice = Invoice::create([
            'invoice_code' => 'INV-' . strtoupper(Str::random(6)),
            'user_id' => $user_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'due_date' => now()->addDay(), // Timer 24 Jam
            'status' => 'pending'
        ]);

        // 2. Kirim Pesan Otomatis ke User
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user_id,
            'message' => "Halo, Tagihan baru telah dibuat: **{$request->title}** senilai **Rp " . number_format($request->amount) . "**. Silakan cek detailnya di atas chat ini.",
            'is_read' => false
        ]);

        return back()->with('success', 'Tagihan berhasil dibuat dan dikirim ke user.');
    }

    public function approveInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update(['status' => 'paid']);

        // Kirim notifikasi ke user
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $invoice->user_id,
            'message' => "Pembayaran untuk tagihan #{$invoice->invoice_code} telah DITERIMA. Terima kasih! Barang akan segera diproses.",
            'is_read' => false
        ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    // Halaman Settings
    public function settings()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    // Proses Update Settings
    public function settingsUpdate(Request $request)
    {
        // Daftar semua input teks yang ada di form settings.blade.php kita
        $keys = [
            'site_name', 'admin_wa', 'midtrans_environment', 
            'midtrans_client_key', 'midtrans_server_key', 
            'site_phone', 'site_email', 'site_address'
        ];

        // Looping untuk menyimpan setiap data ke tabel settings
        foreach ($keys as $key) {
            if ($request->has($key)) {
                // Gunakan DB facade agar aman kalau kamu belum punya Model khusus Setting
                \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(
                    ['key' => $key],
                    ['value' => $request->$key]
                );
            }
        }

        // Khusus untuk upload Logo (jika ada file yang diupload)
        if ($request->hasFile('site_logo')) {
            $file = $request->file('site_logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke folder public/uploads/settings
            $file->move(public_path('uploads/settings'), $filename);
            
            \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(
                ['key' => 'site_logo'],
                ['value' => 'uploads/settings/' . $filename]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan!');
    }

    public function customers()
    {
        // Ambil semua user yang role-nya 'user'
        $customers = User::where('role', 'user')->orderBy('created_at', 'desc')->get();
        return view('admin.customers', compact('customers'));
    }

    public function customerDestroy($id)
    {
        $customer = User::findOrFail($id);
        
        // Pastikan tidak menghapus admin
        if($customer->role == 'admin') {
            return back()->with('error', 'Tidak bisa menghapus Admin!');
        }

        $customer->delete();
        return back()->with('success', 'Customer berhasil dihapus.');
    }

    public function reports(Request $request)
    {
        $query = \App\Models\Invoice::where('status', 'paid');

        // 1. Prioritas Utama: Filter berdasarkan Rentang Tanggal (Periode)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('updated_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        } else {
            // 2. Jika tidak pakai rentang tanggal, gunakan filter Bulan & Tahun
            if ($request->filled('month')) {
                $query->whereMonth('updated_at', $request->month);
            }
            if ($request->filled('year')) {
                $query->whereYear('updated_at', $request->year);
            }
        }

        $invoices = $query->orderBy('updated_at', 'desc')->get();
        
        // Hitung total pendapatan dari hasil filter
        $totalPendapatan = $invoices->sum('amount');

        // Ambil daftar tahun unik dari database (agar dropdown tahun otomatis update)
        $availableYears = \App\Models\Invoice::selectRaw('YEAR(updated_at) as year')
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year');
                            
        // Jika database masih kosong, setidaknya tampilkan tahun ini
        if($availableYears->isEmpty()){
            $availableYears = collect([date('Y')]);
        }

        return view('admin.reports', compact('invoices', 'totalPendapatan', 'availableYears'));
    }

    public function categories()
    {
        // Ambil semua kategori beserta jumlah produk di dalamnya
        $categories = \App\Models\Category::withCount('products')->orderBy('id', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function categoryCreate()
    {
        return view('admin.categories.form'); // Kita pakai 1 file form untuk Create & Edit
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . \Illuminate\Support\Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $filename);
            $imagePath = 'uploads/categories/' . $filename;
        }

        \App\Models\Category::create([
            'name' => $request->name,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function categoryEdit($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        return view('admin.categories.form', compact('category'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $category = \App\Models\Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $imagePath = $category->image; // Default pakai gambar lama
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . \Illuminate\Support\Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $filename);
            $imagePath = 'uploads/categories/' . $filename;
        }

        $category->update([
            'name' => $request->name,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function categoryDestroy($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        
        // Cek apakah ada produk yang pakai kategori ini
        if (\App\Models\Product::where('category_id', $id)->count() > 0) {
            return redirect()->back()->with('error', 'Gagal dihapus! Kategori ini masih digunakan oleh beberapa produk.');
        }

        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil dihapus!');
    }
    
}