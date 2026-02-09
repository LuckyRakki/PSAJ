<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    public function home() {
        $categories = Category::all();
        $totalFeatured = 8; // Tentukan jumlah produk unggulan yang diinginkan
        
        $featuredProducts = new Collection();
        $excludeIds = [];

        // 1. Ambil 1 produk terpopuler dari SETIAP kategori
        foreach ($categories as $category) {
            $mostPopularInCategory = Product::where('category_id', $category->id)
                                            ->orderByDesc('rental_count')
                                            ->first();
            
            if ($mostPopularInCategory) {
                $featuredProducts->push($mostPopularInCategory);
                $excludeIds[] = $mostPopularInCategory->id;
            }
        }
        
        // 2. Hitung sisa slot yang perlu diisi
        $remainingSlots = $totalFeatured - $featuredProducts->count();
        
        // 3. Isi sisa slot dengan produk terpopuler lainnya (yang belum terpilih)
        if ($remainingSlots > 0) {
            $remainingProducts = Product::whereNotIn('id', $excludeIds)
                                        ->orderByDesc('rental_count')
                                        ->take($remainingSlots)
                                        ->get();
            
            $featuredProducts = $featuredProducts->merge($remainingProducts);
        }

        // Pastikan total tidak lebih dari yang ditentukan, lalu urutkan sekali lagi
        $featuredProducts = $featuredProducts->sortByDesc('rental_count')->take($totalFeatured);

        return view('home', compact('categories', 'featuredProducts'));
    }

    // ... (method index() dan show() biarkan seperti sebelumnya)
    public function index() {
        $allProducts = Product::with('category')->get();
        return view('products', compact('allProducts'));
    }

    public function show($id) {
        $product = Product::with('category')->findOrFail($id);
        return view('product-detail', compact('product'));
    }
}