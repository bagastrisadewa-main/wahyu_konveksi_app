<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // INDEX
public function index(Request $request)
{
    $keyword = $request->input('name');
    $perPage = $request->input('per_page', 10);

    $query = Category::query()
        ->when($keyword, fn($q) => $q->where('name', 'like', "%{$keyword}%"))
        ->orderBy('id', 'desc');

    $categories = $query->paginate($perPage);

    // Jika AJAX, kembalikan JSON untuk JS render
    if ($request->ajax() || $request->has('ajax')) {
        return response()->json([
            'data' => $categories->items(),
            'pagination' => [
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total()
            ]
        ]);
    }

    return view('pages.categories.index');
}




    // CREATE
    public function create()
    {
        return view('pages.categories.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('categories', 'public');
                $images[] = $path;
            }
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'image' => !empty($images) ? json_encode($images) : null,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    // EDIT
    public function edit(Category $category)
    {
        return view('pages.categories.edit', compact('category'));
    }

    // UPDATE
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $images = $category->image ? json_decode($category->image, true) : [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('categories', 'public');
                $images[] = $path;
            }
        }

        $category->update([
            'name' => $request->name,
            'image' => !empty($images) ? json_encode($images) : null,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui');
    }

    // DELETE IMAGE BY INDEX
    public function destroyImage(Category $category, $index)
    {
        $images = $category->image ? json_decode($category->image, true) : [];

        if (isset($images[$index])) {
            if (\Storage::exists('public/' . $images[$index])) {
                \Storage::delete('public/' . $images[$index]);
            }

            unset($images[$index]);
            $images = array_values($images);

            $category->update([
                'image' => !empty($images) ? json_encode($images) : null,
            ]);

            return response()->json(['success' => true, 'message' => 'Gambar berhasil dihapus']);
        }

        return response()->json(['success' => false, 'message' => 'Gambar tidak ditemukan'], 404);
    }

    // DELETE CATEGORY
// DELETE CATEGORY
public function destroy(Category $category)
{
    try {
        // Hapus gambar jika ada
        if ($category->image) {
            foreach (json_decode($category->image, true) as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $category->delete();

        // Jika request AJAX → kembalikan JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus'
            ]);
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus');

    } catch (\Exception $e) {
        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori'
            ], 500);
        }

        return redirect()->back()->with('error', 'Gagal menghapus kategori');
    }
}

}
