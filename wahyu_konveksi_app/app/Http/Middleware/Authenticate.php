<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // 🔹 BACKEND / ADMIN
    // 🔐 BACKEND / ADMIN
    if (
        $request->is('home') ||
        $request->is('home/*') ||

        // admin prefix
        $request->is('admin') ||
        $request->is('admin/*') ||

        // route admin tanpa prefix
        $request->is('orders*') ||
        $request->is('product*') ||
        $request->is('customers*') ||
        $request->is('settings*') ||
        $request->is('user*') ||
        $request->is('laporan*') ||
        $request->is('notifications/*') ||
        $request->is('galleries*') ||
        $request->is('navigation-menus*') ||
        $request->is('sliders*') ||
        $request->is('about*')
    ) {
        return route('admin.login');
    }


        // 🔹 FRONTEND / CUSTOMER
        return route('frontend.login');
    }
}
