<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $query = Slider::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $sliders = $query->orderBy('order', 'asc')->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('pages.slider.partials.table', compact('sliders'))->render()
            ]);
        }

        return view('pages.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('pages.slider.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'order'       => 'nullable|integer',
            'is_active'   => 'required|boolean',
        ]);

        $data = $request->only([
            'title','subtitle','button_text','button_link','order','is_active'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        Slider::create($data);

        return redirect()->route('sliders.index')->with('success', 'Slider berhasil ditambahkan');
    }

    public function edit(Slider $slider)
    {
        return view('pages.slider.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'order'       => 'nullable|integer',
            'is_active'   => 'required|boolean',
        ]);

        $data = $request->only([
            'title','subtitle','button_text','button_link','order','is_active'
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($data);

        return redirect()->route('sliders.index')->with('success', 'Slider berhasil diperbarui');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();

        return redirect()->route('sliders.index')->with('success', 'Slider berhasil dihapus');
    }
}
