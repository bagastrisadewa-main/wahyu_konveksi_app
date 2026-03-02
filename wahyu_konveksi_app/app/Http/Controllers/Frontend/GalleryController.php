<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Gallery;
use App\Models\Category;
use App\Models\NavigationMenu;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
        public function index(Request $request)
        {
            $navigationMenus = NavigationMenu::where('active', 1)
                ->orderBy('order')
                ->get();

            $sliders = Slider::where('is_active', 1)
                ->orderBy('order')
                ->get();

            $titleId = $request->query('title');

            // ✅ HANYA gallery ACTIVE
            $allGalleries = Gallery::where('status', 'active')
                ->latest()
                ->get();

            // ✅ Kategori + gallery ACTIVE saja
            $categories = Category::with(['galleries' => function ($q) {
                $q->where('status', 'active')
                ->orderByDesc('id');
            }])->get();

            // ✅ Gallery tanpa kategori (ACTIVE saja)
            $uncategorized = Gallery::whereNull('category_id')
                ->where('status', 'active')
                ->orderByDesc('id')
                ->get();

            // ✅ Filter grid
            if ($titleId) {
                $selectedGallery = Gallery::where('id', $titleId)
                    ->where('status', 'active')
                    ->get();
            } else {
                $selectedGallery = Gallery::where('status', 'active')
                    ->latest()
                    ->get();
            }

            return view('frontend.pages.gallery.index', compact(
                'navigationMenus',
                'sliders',
                'categories',
                'uncategorized',
                'allGalleries',
                'selectedGallery'
            ));
        }

}
