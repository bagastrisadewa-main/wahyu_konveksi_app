<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\NavigationMenu;
use Illuminate\Http\Request;
use App\Models\Slider;

class ArticleController extends Controller
{
    /**
     * List artikel frontend
     */
    public function index(Request $request)
    {
        $layout = $request->input('layout', 'default');

        $query = Article::with('images')
            ->where('is_published', true);

        // pencarian artikel
        if ($request->has('q')) {
            $query->where('title', 'like', '%'.$request->q.'%')
                  ->orWhere('content', 'like', '%'.$request->q.'%');
        }

        $paginatedArticles = $query->orderBy('created_at', 'desc')->paginate(9);

        $navigationMenus = NavigationMenu::orderBy('order', 'asc')->get();

        // ambil sliders
        $sliders = Slider::where('is_active', 1)
            ->orderBy('order')
            ->get();

       return view('frontend.pages.artikel.index', compact('paginatedArticles', 'layout', 'navigationMenus', 'sliders'));
    }
}
