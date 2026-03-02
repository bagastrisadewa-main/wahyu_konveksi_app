<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
        public function index(Request $request)
        {
            $query = Gallery::with('category');

            // 🔍 SEARCH (sama seperti slider)
            if ($request->has('title') && !empty($request->title)) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            $galleries = $query
                ->orderBy('id', 'desc')
                ->paginate($request->per_page ?? 10);

            // Ajax response
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('pages.galleries.partials.table', compact('galleries'))->render()
                ]);
            }

            return view('pages.galleries.index', compact('galleries'));
        }

    public function create()
    {
        $categories = Category::all();
        return view('pages.galleries.create', compact('categories'));
    }

    public function store(Request $request)
    {
            $request->validate([
                'category_id' => 'nullable|exists:categories,id', // diubah dari required
                'title'       => 'required|string|max:255',
                'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'nullable|string',
                'status'      => 'required|in:active,inactive',
            ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('galleries', 'public');
            }
        }

            Gallery::create([
                'category_id' => $request->category_id ?: null, // supaya kosong jadi null
                'title'       => $request->title,
                'image'       => json_encode($images),
                'description' => $request->description,
                'status'      => $request->status,
            ]);

        return redirect()->route('galleries.index')->with('success', 'Gallery berhasil ditambahkan');
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        $categories = Category::all();
        return view('pages.galleries.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title'       => 'required|string|max:255',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $oldImages = $gallery->image ? json_decode($gallery->image, true) : [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $oldImages[] = $file->store('galleries', 'public');
            }
        }
        $gallery->update([
            'category_id' => $request->category_id ?: null,
            'title'       => $request->title,
            'image'       => json_encode($oldImages),
            'description' => $request->description,
            'status'      => $request->status,
        ]);


        return redirect()->route('galleries.index')->with('success', 'Gallery berhasil diperbarui');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->image) {
            foreach (json_decode($gallery->image, true) as $img) {
                if (Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        $gallery->delete();

        return redirect()->route('galleries.index')->with('success', 'Gallery berhasil dihapus');
    }

    // hapus 1 gambar dari gallery
    public function destroyImage($galleryId, $index)
    {
        $gallery = Gallery::findOrFail($galleryId);
        $images = $gallery->image ? json_decode($gallery->image, true) : [];

        if (isset($images[$index])) {
            $img = $images[$index];
            if (Storage::disk('public')->exists($img)) {
                Storage::disk('public')->delete($img);
            }

            unset($images[$index]);
            $gallery->image = json_encode(array_values($images)); // reset index
            $gallery->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Gambar tidak ditemukan'], 404);
    }
}
