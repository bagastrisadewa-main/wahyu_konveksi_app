<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\AboutUs;
use App\Models\NavigationMenu;
use App\Models\Category; // 👈 tambahkan ini
use App\Models\Product; // ✅ Tambahkan ini
use App\Models\Article;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $navigationMenus = NavigationMenu::where('active', 1)
            ->orderBy('order')
            ->get();

        $sliders = Slider::where('is_active', 1)
            ->orderBy('order')
            ->get();

        $about = AboutUs::first();

        // ✅ Ambil kategori aktif
        $categories = Category::orderBy('name')->get();

                // ✅ Ambil 8 produk aktif terbaru
            $products = Product::where('is_active', 1)
                ->latest()
                ->take(8)
                ->get();

        return view('frontend.pages.beranda.beranda', compact('navigationMenus', 'sliders', 'about', 'categories','products'));
    }

        // ✅ Fungsi search kategori
            public function search(Request $request)
            {
                $keyword = $request->input('q');

                $categories = Category::where('name', 'like', "%{$keyword}%")
                    ->orderBy('name')
                    ->get(['id', 'name', 'slug']);

            // ✅ Cari Produk
            $products = Product::where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%")
                ->limit(5)
                ->get(['id', 'name', 'slug']);

            // ✅ Cari Artikel
            $articles = Article::where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('content', 'LIKE', "%{$keyword}%")
                ->limit(5)
                ->get(['id', 'title', 'slug']);

            return response()->json([
                'categories' => $categories,
                'products' => $products,
                'articles' => $articles,
            ]);
    }
}
