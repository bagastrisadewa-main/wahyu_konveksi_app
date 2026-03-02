<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class AuthController extends Controller
{
    // =====================
    // FORM LOGIN
    // =====================
    public function login()
    {
        return view('frontend.auth.login');
    }

    // =====================
    // PROSES LOGIN
    // =====================
// PROSES LOGIN
public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::guard('customer')->attempt($credentials)) {
        $request->session()->regenerate();

        $redirectTo = $request->input('redirect');

        return $redirectTo
            ? redirect($redirectTo)->with('success', 'Login berhasil')
            : redirect()->intended('/')->with('success', 'Login berhasil');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah',
    ])->withInput();
}



    // AuthController.php
        // public function profile()
        // {
        //     $customer = Auth::guard('customer')->user();
        //     return view('frontend.auth.profile', compact('customer'));
        // }



        // =====================
        // LOGOUT
        // =====================
        // public function logout(Request $request)
        // {
        //     Auth::guard('customer')->logout();

        //     $request->session()->invalidate();
        //     $request->session()->regenerateToken();

        //     return redirect('/')
        //         ->with('success', 'Berhasil logout');
        // }


    // =====================
    // FORM REGISTER
    // =====================
    public function register()
    {
        return view('frontend.auth.register');
    }

    // =====================
    // PROSES REGISTER
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:customers,email',
            'phone'    => 'required|string|max:20',
            'address'  => 'required|string|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        Customer::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'address'    => $request->address,
            'password'   => Hash::make($request->password),
            'is_active'  => true,
        ]);

        return redirect()->route('frontend.login')
            ->with('success', 'Registrasi berhasil, silakan login');
    }

    // =====================
    // LOGOUT
    // =====================
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Berhasil logout');
    }
}
