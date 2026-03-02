<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\AboutUs;
use App\Models\NavigationMenu;

class TentangKamiController extends Controller
{
    public function index()
    {
        // Ambil menu navigasi aktif
        $navigationMenus = NavigationMenu::where('active', 1)
            ->orderBy('order')
            ->get();

        // Ambil slider aktif
        $sliders = Slider::where('is_active', 1)
            ->orderBy('order')
            ->get();

        // Ambil semua data AboutUs
        $abouts = AboutUs::orderBy('id')->get();

        return view('frontend.pages.tentang-kami.index', compact(
            'navigationMenus',
            'sliders',
            'abouts'
        ));
    }
}
