<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;

class CategoriesController extends Controller
{
    // Index: slider + kategori
    public function index()
    {
        $categories = Category::all();
        $sliders = Slider::where('is_active', 1)->get(); // slider aktif
        return view('frontend.pages.categories.index', compact('categories', 'sliders'));
    }

    // Show: detail kategori + produk
public function show($slug)
{
    $category = Category::where('slug', $slug)->firstOrFail();
    $products = $category->products()->where('is_active', 1)->get();
    $sliders = Slider::where('is_active', 1)->get();

    return view('frontend.pages.categories.show', compact('category', 'products', 'sliders'));
}

}
