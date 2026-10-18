<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Tambahkan
use App\Models\Setting; // Tambahkan
use App\Models\NavigationMenu;
use App\Models\Category;
use App\Models\Article; // pastikan sudah ada di atas

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
        if (config('app.env') === 'production' || env('APP_ENV') === 'production' || isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
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
