<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;          // Tambahan
use Illuminate\Support\Facades\URL;           // Tambahan (opsional, dipakai via façade)
use App\Models\Setting;
use App\Models\NavigationMenu;
use App\Models\Category;
use App\Models\Article;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1️⃣ Paksa semua URL yang di‑generate Laravel memakai HTTPS
        URL::forceScheme('https');

        // 2️⃣ Paksa root URL agar sesuai dengan nilai APP_URL (yang sudah
        //    di‑set di environment Vercel → https://*.vercel.app atau domain tetap)
        if (config('app.url')) {
            URL::forceRootUrl(config('app.url'));
        }

        // 3️⃣ Pastikan request dianggap lewat HTTPS (untuk beberapa server yang
        //    tidak otomatis meng‑set header)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Tetap gunakan Bootstrap 4 untuk pagination
        Paginator::useBootstrapFour();

        /**
         * =====================================================
         * GLOBAL VIEW COMPOSER
         * =====================================================
         * Data di sini otomatis tersedia di SEMUA view:
         * - header
         * - footer
         * - login
         * - register
         * - frontend / backend
         */

        // View Composer untuk global settings
        View::composer('*', function ($view) {

            // 🔹 Global App Settings (logo, nama toko, dll)
            $appSettings = Setting::pluck('value', 'key')->all();

            // 🔹 Menu Navigasi Frontend
            $navigationMenus = NavigationMenu::where('active', 1)
                ->orderBy('order')
                ->get();

            // ✅ Tambahan
            $categories = Category::orderBy('name')->take(5)->get();

            // ✅ KHUSUS HEADER / FOOTER (LIMIT 5)
            $menuCategories = Category::orderBy('name')
                ->take(5)
                ->get();

            $articles = Article::where('is_published', 1)
                ->latest()
                ->take(5)
                ->get();

            // Untuk halaman index artikel dengan pagination
            // $articles = Article::where('is_published', 1)
            //     ->latest()
            //     ->paginate(10); // 10 artikel per halaman

            $view->with([
                'appSettings'     => $appSettings,
                'navigationMenus' => $navigationMenus,
                'menuCategories'  => $menuCategories,
                'categories'      => $categories,
                'articles'        => $articles,
            ]);
        });
    }
}