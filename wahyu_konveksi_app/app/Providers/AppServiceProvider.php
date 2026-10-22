<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
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
        // Paksa semua URL (asset(), url(), route()) memakai HTTPS di server.
        // Di lokal (APP_ENV=local) tetap http agar development tidak terganggu.
        if (! $this->app->environment('local')) {
            URL::forceScheme('https');
        }

        // Tetap gunakan Bootstrap 4 untuk pagination
        Paginator::useBootstrapFour();

        /**
         * GLOBAL VIEW COMPOSER
         * Data di sini otomatis tersedia di SEMUA view.
         */
        View::composer('*', function ($view) {

            // Global App Settings (logo, nama toko, dll)
            $appSettings = Setting::pluck('value', 'key')->all();

            // Menu Navigasi Frontend
            $navigationMenus = NavigationMenu::where('active', 1)
                ->orderBy('order')
                ->get();

            $categories = Category::orderBy('name')->take(5)->get();

            // Khusus header / footer (limit 5)
            $menuCategories = Category::orderBy('name')
                ->take(5)
                ->get();

            $articles = Article::where('is_published', 1)
                ->latest()
                ->take(5)
                ->get();

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
