<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // 1. Dashboard Utama
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::where('role', 'user')->count();
        
        return view('admin.dashboard', compact('totalProducts', 'totalCategories', 'totalUsers'));
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
        // 1. Ambil daftar User yang pernah chat dengan Admin (baik kirim atau terima)
        // Kita gunakan query ini agar user yang baru saja chat muncul paling atas
        $users = User::where('role', 'user')
            ->whereHas('sentMessages', function($q) {
                $q->where('receiver_id', Auth::id());
            })
            ->orWhereHas('receivedMessages', function($q) {
                $q->where('sender_id', Auth::id());
            })
            ->withCount(['sentMessages as unread' => function($q) {
                $q->where('receiver_id', Auth::id())->where('is_read', false);
            }])
            ->get();

        // 2. Jika ada user yang dipilih (diklik dari list)
        $messages = [];
        $currentUser = null;

        if ($user_id) {
            $currentUser = User::findOrFail($user_id);
            
            // Tandai pesan dari user ini sebagai "sudah dibaca"
            Message::where('sender_id', $user_id)
                   ->where('receiver_id', Auth::id())
                   ->update(['is_read' => true]);

            // Ambil percakapan
            $messages = Message::where(function($q) use ($user_id) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $user_id);
            })->orWhere(function($q) use ($user_id) {
                $q->where('sender_id', $user_id)->where('receiver_id', Auth::id());
            })->orderBy('created_at', 'asc')->get();
        }

        return view('admin.chat.index', compact('users', 'messages', 'currentUser'));
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
}