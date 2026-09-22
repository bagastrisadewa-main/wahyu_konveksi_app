<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function index()
    {
        return view('pages.settings.index', [
            'settings' => Setting::all()->pluck('value', 'key')
        ]);
    }
public function update(Request $request)
{
    \Log::info('▶️ Memasuki SettingController@update');

    $validated = $request->validate([
        'store_name' => 'required|string|max:100',
        'store_footer_text' => 'nullable|string|max:255',
        'store_address' => 'nullable|string|max:255',
        'store_phone' => 'nullable|string|max:20',
        'store_instagram' => 'nullable|url',
        'store_tiktok' => 'nullable|url',
        'theme' => 'nullable|in:light,dark',
        'store_logo' => 'nullable|image|max:2048',
        'store_logo_alt' => 'nullable|image|max:2048',

            // 🔹 Rekening Owner
    'bank_name' => 'nullable|string|max:100',
    'bank_account_number' => 'nullable|string|max:50',
    'bank_account_holder' => 'nullable|string|max:100',
    ]);

    try {
        Setting::setValue('store_name', $validated['store_name']);
        Setting::setValue('store_footer_text', $validated['store_footer_text']);
        Setting::setValue('store_address', $validated['store_address']);
        Setting::setValue('store_phone', $validated['store_phone']);
        Setting::setValue('store_instagram', $validated['store_instagram']);
        Setting::setValue('store_tiktok', $validated['store_tiktok']);
        Setting::setValue('theme', $validated['theme'] ?? 'light');

        // 🔹 Rekening Owner
        Setting::setValue('bank_name', $validated['bank_name'] ?? null);
        Setting::setValue('bank_account_number', $validated['bank_account_number'] ?? null);
        Setting::setValue('bank_account_holder', $validated['bank_account_holder'] ?? null);

        // ✅ Upload logo utama
        if ($request->hasFile('store_logo')) {
            $logo = $request->file('store_logo');
            if ($logo->isValid()) {
                $filename = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
                $logo->storeAs('settings', $filename, 'public');
                Setting::setValue('store_logo', $filename);
                \Log::info('✅ Logo utama berhasil diupload: ' . $filename);
            }
        }

        // ✅ Upload logo alternatif
        if ($request->hasFile('store_logo_alt')) {
            $logoAlt = $request->file('store_logo_alt');
            if ($logoAlt->isValid()) {
                $filenameAlt = 'logo_alt_' . time() . '.' . $logoAlt->getClientOriginalExtension();
                $logoAlt->storeAs('settings', $filenameAlt, 'public');
                Setting::setValue('store_logo_alt', $filenameAlt);
                \Log::info('✅ Logo alternatif berhasil diupload: ' . $filenameAlt);
            }
        }

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    } catch (\Throwable $e) {
        \Log::error('❌ Gagal update setting: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan pengaturan.');
    }
}




}
