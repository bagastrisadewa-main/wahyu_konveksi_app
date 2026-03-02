<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
// use App\Http\Controllers\CategoryController as AdminCategoryController;
// use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Admin\NavigationMenuController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Frontend\TentangKamiController;
use App\Http\Controllers\Frontend\BerandaController;
use App\Http\Controllers\GalleryController as AdminGalleryController;
use App\Http\Controllers\Frontend\GalleryController as FrontendGalleryController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Frontend\ArticleController as FrontendArticleController;
use App\Http\Controllers\Frontend\DetailArtikelController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\CategoriesController;
use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\NotificationController;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DatabaseController;






/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



// ✅ Route untuk frontend (beranda publik, tanpa login)
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
// ✅ Alias untuk slug /beranda (biar link lama masih berfungsi)
Route::get('/beranda', [BerandaController::class, 'index']);


Route::prefix('kategori')->name('categories.')->group(function() {
    // Index kategori: slider + daftar kategori
    Route::get('/', [CategoriesController::class, 'index'])->name('index');

    // Show kategori: detail kategori + produk
    Route::get('/{slug}', [CategoriesController::class, 'show'])->name('show');
});

// Route produk (pakai route model binding dengan slug)
// Route::get('/produk/{product:slug}', [ProductController::class, 'show'])
//     ->name('frontend.products.show');


Route::get('/tentang-kami', [TentangKamiController::class, 'index'])->name('tentang.kami');

// Route frontend
Route::get('/gallery', [FrontendGalleryController::class, 'index'])->name('frontend.gallery.index');

// Artikel frontend
Route::prefix('artikel')->name('frontend.artikel.')->group(function () {
    Route::get('/', [FrontendArticleController::class, 'index'])->name('index');
});


// Detail artikel
Route::prefix('detail-artikel')->name('frontend.detail_artikel.')->group(function () {
    Route::get('/{article:slug}', [DetailArtikelController::class, 'show'])
        ->name('show');

    Route::post('/{id}/comment', [CommentController::class, 'store'])
        ->middleware('auth:customer')
        ->name('comment');
});
// Route::prefix('detail-artikel')->name('frontend.detail_artikel.')->group(function () {
//     Route::get('/{slug}', [DetailArtikelController::class, 'show'])->name('show');
//     Route::post('/{id}/comment', [DetailArtikelController::class, 'comment'])->name('comment');
// });

// Detail produk

Route::prefix('produk')->group(function () {

    Route::get('/', [FrontendProductController::class, 'index'])
        ->name('frontend.products.index');

    Route::get('/{product:slug}', [FrontendProductController::class, 'show'])
        ->name('frontend.products.show');

});



// ===== AUTH CUSTOMER (FRONTEND) =====
Route::middleware('guest:customer')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('frontend.login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('frontend.login.submit');

    Route::get('/register', [AuthController::class, 'register'])->name('frontend.register');
    Route::post('/register', [AuthController::class, 'store'])->name('frontend.register.submit');
});

Route::get('/search', [BerandaController::class, 'search'])->name('search');



// web.php
Route::middleware('auth:customer')->group(function () {
        Route::get('/customer/profile', [ProfileController::class, 'index'])
            ->name('frontend.profile');
            // ================= HISTORY ORDER =================
            Route::get('/history-order', [\App\Http\Controllers\Frontend\OrderHistoryController::class, 'index'])
                ->name('frontend.orders.history');

            Route::get('/history-order/{order}', [\App\Http\Controllers\Frontend\OrderHistoryController::class, 'show'])
                ->name('frontend.orders.history.show');
            Route::post('/history-order/{order}/reorder',
                [\App\Http\Controllers\Frontend\OrderHistoryController::class, 'reorder'])
                ->name('frontend.orders.reorder');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('frontend.profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('frontend.profile.update');
        Route::post('/logout', [AuthController::class, 'logout'])->name('frontend.logout');
        });
            Route::middleware('auth:customer')
            ->prefix('cart')
            ->name('frontend.cart.')
            ->group(function () {

                // ================= CART PAGE =================
                Route::get('/', [CartController::class, 'index'])
                    ->name('index');

                // ================= ADD ITEM =================
                Route::post('/add', [CartController::class, 'add'])
                    ->name('add');

                // ================= AJAX =================
                Route::post('/ajax/update/{itemId}', [CartController::class, 'ajaxUpdate'])
                    ->name('ajax.update');

                // (opsional, kalau belum dipakai bisa dihapus)
                // Route::post('/ajax/remove/{itemId}', [CartController::class, 'ajaxRemove'])
                //     ->name('ajax.remove');

                // ================= CHECKOUT + WHATSAPP =================
                Route::get('/checkout-wa', [CartController::class, 'checkoutAndWA'])
                    ->name('checkout-wa');

                    
            });


            // ==============================
            // ADMIN LOGIN (BACKEND)
            // ==============================
         Route::get('/adm-login', function () {
            $appSettings = Setting::pluck('value', 'key')->all();
            return view('pages.auth.login', compact('appSettings'));
        })->name('admin.login');

        Route::post('/adm-login', function (Request $request) {
            $credentials = $request->only('email', 'password');

            if (Auth::guard('web')->attempt($credentials)) { // gunakan guard web untuk admin
                return redirect()->intended('/home'); // halaman dashboard admin
            }

            return back()->withErrors([
                'email' => 'Email atau password salah',
            ])->withInput($request->only('email'));
        })->name('admin.login.submit');

        Route::post('/adm-logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');


// ✅ Route untuk semua user yang sudah login (backend / admin area)
  Route::middleware('auth:web')->group(function () {
    Route::delete(
        'galleries/images/{gallery}/{index}',
        [AdminGalleryController::class, 'destroyImage']
    )->name('galleries.images.destroy');

    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');

    // Route::get('/home', [DashboardController::class, 'index'])->name('home');

    // Route::get('/home', [DashboardController::class, 'home'])->name('home');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/activities', [UserController::class, 'activities'])->name('user.activities');

    // ✅ Menu Customers (tanpa create & delete)
    Route::resource('customers', CustomerController::class);

    // ✅ Menu navigasi (CRUD)
    Route::resource('navigation-menus', NavigationMenuController::class);

    // ✅ Slider Image (CRUD)
    Route::resource('sliders', SliderController::class);

    // ✅ Tentang Kami (CRUD)
    Route::resource('about', AboutUsController::class);
    

    Route::resource('galleries', AdminGalleryController::class)->except(['show']);




// CRUD artikel
Route::prefix('admin')->name('admin.')->group(function () {
    // CRUD artikel
    Route::resource('articles', AdminArticleController::class);

    // Hapus gambar artikel (AJAX)
    Route::delete('articles/{id}/images/{imageId}', [AdminArticleController::class, 'destroyImage'])
        ->name('articles.images.destroy');

    // Upload gambar Summernote (AJAX)
    Route::post('articles/upload-image', [AdminArticleController::class, 'uploadImage'])
        ->name('articles.upload.image');
});


    // ✅ Admin only (gunakan middleware checkrole:admin)
    Route::middleware('checkrole:admin')->group(function () {
        Route::resource('user', UserController::class);

        // ✅ Menu pengaturan aplikasi
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // ✅ Notifikasi stok produk rendah
    Route::get('/notifications/orders', [NotificationController::class, 'orders'])->name('notifications.orders');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Route::get('/notifications/stock', [ProductController::class, 'lowStockNotifications'])
    //     ->name('product.notifications');

    // Route::get('/product/notif-dropdown', [ProductController::class, 'lowStockNotifications'])
    //     ->name('product.notifications');

                // Hapus gambar produk (AJAX)
        Route::delete('/product/image/{id}',
            [ProductController::class, 'deleteImage']
        )->name('product.image.delete');

    // ✅ Semua role bisa akses
    Route::resource('product', ProductController::class);

   Route::resource('orders', OrderController::class)
    ->only(['index','show']);

    // Update status order per item (AJAX)
    Route::post('/orders/{id}/status', [OrderController::class, 'updateOrderStatus'])
        ->name('order.updateStatus');

    // Update proses item (AJAX)
    Route::post('/orders/item/{id}/process', [OrderController::class, 'updateItemProcess'])
        ->name('order.updateItemProcess');

    // Simpan perubahan status order + proses item sekaligus (dari tombol "Simpan Perubahan")
    Route::post('/orders/{id}/save', [OrderController::class, 'saveOrderUpdates'])
        ->name('order.save');

    // Kirim WA
    Route::get('/orders/{id}/send-wa', [OrderController::class, 'sendWA'])
        ->name('order.sendWA');

        // ==============================
// CATEGORY (ADMIN)
// ==============================
Route::prefix('admin')->name('admin.')->group(function () {

    // INDEX + AJAX SEARCH
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

    // CREATE
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');

    // STORE
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

    // EDIT
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');

    // UPDATE
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

    // DESTROY
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // DESTROY IMAGE BY INDEX (AJAX)
    Route::delete('/categories/{category}/image/{index}', [CategoryController::class, 'destroyImage'])
        ->name('categories.destroyImage');
});

        // Route::resource('order', OrderController::class);

//         Route::middleware('auth:web')->prefix('admin')->name('admin.')->group(function () {
//     Route::resource('categories', CategoryController::class);
//     Route::delete('/categories/{category}/images/{index}', [CategoryController::class, 'destroyImage'])
//         ->name('categories.images.destroy');
// });

    //     Route::middleware('auth:web')->prefix('admin')->name('admin.')->group(function () {
    //     Route::resource('categories', AdminCategoryController::class);
    // });
        // Route::resource('categories', CategoryController::class);
    // Route backend (admin)
    Route::resource('galleries', AdminGalleryController::class);



    Route::get('database', [DatabaseController::class, 'index'])->name('database.index');
    Route::post('database/backup', [DatabaseController::class, 'backup'])->name('database.backup');
    Route::post('database/restore', [DatabaseController::class, 'restore'])->name('database.restore');
    Route::post('database/reset', [DatabaseController::class, 'reset'])->name('database.reset');
    Route::get('database/download/{file}', [DatabaseController::class, 'download'])->name('database.download');




    // Route::delete('/categories/{category}/images/{index}', [CategoryController::class, 'destroyImage'])
    //     ->name('categories.images.destroy');



    // Route::resource('articles', ArticleController::class);

    // ✅ Laporan Penjualan
    Route::get('laporan', [ReportController::class, 'index'])->name('report.index');
    Route::get('laporan/export/excel', [ReportController::class, 'exportExcel'])->name('report.export.excel');
    Route::get('laporan/export/pdf', [ReportController::class, 'exportPdf'])->name('report.export.pdf');
    Route::get('laporan/print', [ReportController::class, 'print'])->name('report.print');
});
