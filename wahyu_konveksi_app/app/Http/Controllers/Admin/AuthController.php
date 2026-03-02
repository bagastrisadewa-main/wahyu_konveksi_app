<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
        public function logout()
        {
            Auth::guard('web')->logout(); // logout admin

            // Hapus session dan regenerate token
            session()->invalidate();
            session()->regenerateToken();

            // Redirect ke login admin
            return redirect()->route('admin.login');
        }

}
