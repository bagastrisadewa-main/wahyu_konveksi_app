<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request; // ⬅️ ini wajib

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->where('is_active', true)
            ->whereNotNull('images')
            ->where('images', '!=', '[]')
            ->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->paginate(20)->withQueryString(); // tetap bawa filter di pagination

        $categories = Category::orderBy('name')->get();

        return view('frontend.products.index', compact('products', 'categories'));
    }

            public function show(Product $product)
        {
            $product->load([
                'category',
                'options.values'
            ]);

                $relatedProducts = Product::where('is_active', true)
                ->where('id', '!=', $product->id) // ✅ ini AMAN (internal DB only)
                ->latest()
                ->take(6)
                ->get();

            return view('frontend.products.show', compact('product', 'relatedProducts'));
        }


    // public function show(Product $product)
    // {
    //     abort_if(!$product->is_active, 404);

    //     $product->load('category');

    //     $relatedProducts = Product::where('is_active', true)
    //         ->where('id', '!=', $product->id)
    //         ->latest()
    //         ->take(6)
    //         ->get();

    //     return view('frontend.products.show', compact('product', 'relatedProducts'));
    // }

}
