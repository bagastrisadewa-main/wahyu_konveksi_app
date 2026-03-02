<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index(Request $request)
    {
        $query = AboutUs::query();

        if ($request->has('title') && $request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $perPage = $request->get('per_page', 10);
        $abouts = $query->latest()->paginate($perPage)->appends($request->all());

        if ($request->ajax()) {
            return response()->json([
                'html' => view('pages.tentang_kami.partials.table', compact('abouts'))->render()
            ]);
        }

        return view('pages.tentang_kami.index', compact('abouts'));
    }

    public function create()
    {
        return view('pages.tentang_kami.create');
    }

public function store(Request $request)
{
    $request->validate([
        'title'         => 'required|string|max:255',
        'description'   => 'required|string',
        'image'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        'banner_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'banner_title'  => 'nullable|string|max:255',
    ]);

    // Cek apakah banner sudah ada
    if (($request->hasFile('banner_image') && $request->file('banner_image')->isValid()) || $request->banner_title) {
        $bannerExists = AboutUs::whereNotNull('banner_title')
            ->orWhereNotNull('banner_image')
            ->exists();

        if ($bannerExists) {
            return redirect()->back()->with('error', 'Banner sudah ada, tidak bisa ditambahkan lagi.');
        }
    }

    $data = $request->only(['title', 'description', 'banner_title']);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('about', 'public');
    }

    if ($request->hasFile('banner_image')) {
        $data['banner_image'] = $request->file('banner_image')->store('about/banner', 'public');
    }

    AboutUs::create($data);

    return redirect()->route('about.index')->with('success', 'Data berhasil ditambahkan.');
}

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title'         => 'required|string|max:255',
    //         'description'   => 'required|string',
    //         'image'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    //         'banner_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    //         'banner_title'  => 'nullable|string|max:255',
    //     ]);

    //     $data = $request->only(['title','description','banner_title']);

    //     if ($request->hasFile('image')) {
    //         $data['image'] = $request->file('image')->store('about', 'public');
    //     }

    //     if ($request->hasFile('banner_image')) {
    //         $data['banner_image'] = $request->file('banner_image')->store('about/banner', 'public');
    //     }

    //     AboutUs::create($data);

    //     return redirect()->route('about.index')->with('success', 'Data berhasil ditambahkan.');
    // }

    // Hanya satu edit() method
    public function edit(AboutUs $about)
    {
        // Cek apakah ada banner di record lain selain yang sedang diedit
        $bannerExists = AboutUs::whereNotNull('banner_title')
                        ->orWhereNotNull('banner_image')
                        ->where('id', '!=', $about->id)
                        ->exists();

        return view('pages.tentang_kami.edit', compact('about', 'bannerExists'));
    }

    public function update(Request $request, AboutUs $about)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_title'  => 'nullable|string|max:255',
        ]);

        // Cek banner jika ada input baru
        if (($request->hasFile('banner_image') && $request->file('banner_image')->isValid()) || $request->banner_title) {
            $bannerExists = AboutUs::whereNotNull('banner_title')
                            ->orWhereNotNull('banner_image')
                            ->where('id', '!=', $about->id)
                            ->exists();

            if ($bannerExists) {
                return redirect()->back()->with('error', 'Banner sudah ada di record lain, tidak bisa ditambahkan.');
            }
        }

        $data = $request->only(['title', 'description', 'banner_title']);

        // Update gambar utama
        if ($request->hasFile('image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $data['image'] = $request->file('image')->store('about', 'public');
        }

        // Update banner
        if ($request->hasFile('banner_image')) {
            if ($about->banner_image) {
                Storage::disk('public')->delete($about->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('about/banner', 'public');
        }

        $about->update($data);

        return redirect()->route('about.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(AboutUs $about)
    {
        if ($about->image) {
            Storage::disk('public')->delete($about->image);
        }
        if ($about->banner_image) {
            Storage::disk('public')->delete($about->banner_image);
        }

        $about->delete();

        return redirect()->route('about.index')->with('success', 'Data berhasil dihapus.');
    }

}
