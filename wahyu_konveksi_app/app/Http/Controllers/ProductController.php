<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;

class ProductController extends Controller
{
    /* ===============================
     * INDEX
     * =============================== */
            public function index(Request $request)
            {
                $keyword = $request->name;
                $perPage = $request->per_page ?? 10;

                $products = Product::with('category', 'options.values')
                    ->when($keyword, function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%")
                        ->orWhereHas('category', function ($c) use ($keyword) {
                            $c->where('name', 'like', "%{$keyword}%");
                        });
                    })
                    ->latest()
                    ->paginate($perPage)
                    ->withQueryString();

                // 🔥 JIKA AJAX → RETURN PARTIAL
                if ($request->ajax()) {
                    return response()->json([
                        'html' => view('pages.products.partials.table', compact('products'))->render()
                    ]);
                }

                return view('pages.products.index', compact('products'));
            }


    /* ===============================
     * CREATE
     * =============================== */
    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('pages.products.create', compact('categories'));
    }



                /* ===============================
                * CREATE PRODUCT
                * =============================== */
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|min:3|unique:products',
        'price' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'options.*.name' => 'nullable|string',
        'options.*.type' => 'nullable|in:checkbox,select,number',
        'options.*.values'=> 'nullable|array',
    ]);

    $this->validateOptions($request);

    DB::transaction(function () use ($request) {

        // ===== Upload Images =====
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $images[] = $img->store('products', 'public');
            }
        }

        // ===== Base Price =====
        $basePrice = (int) preg_replace('/\D/', '', $request->price);

        // ===== Auto Select All =====
        $autoAll = $request->boolean('auto_select_all_custom');
        $totalExtra = 0;
        if ($autoAll && $request->options) {
            foreach ($request->options as $opt) {
                if (!empty($opt['values'])) {
                    foreach ($opt['values'] as $val) {
                        $totalExtra += (int) preg_replace('/\D/', '', $val['extra_price'] ?? 0);
                    }
                }
            }
        }

        // ===== Create Product =====
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $basePrice + $totalExtra,
            'stock' => 0,
            'category_id' => $request->category_id,
            'images' => $images,
            'is_best_seller' => $request->boolean('is_best_seller'),
            'is_custom' => $request->boolean('is_custom'),
            'is_active' => $request->boolean('is_active'),
            'auto_select_all_custom' => $autoAll,
        ]);

        // ===== Insert Options =====
        if ($request->options) {
            foreach ($request->options as $opt) {
                if (empty($opt['name'])) continue;

                $option = $product->options()->create([
                    'name' => $opt['name'],
                    'type' => $opt['type'] ?? 'select', // default type
                    'is_required' => $autoAll ? 1 : ($opt['is_required'] ?? 0),
                ]);

                if (!empty($opt['values'])) {
                    foreach ($opt['values'] as $val) {
                        if (!empty($val['label'])) {
                            $option->values()->create([
                                'label' => $val['label'],
                                'extra_price' => (int) preg_replace('/\D/', '', $val['extra_price'] ?? 0),
                            ]);
                        }
                    }
                }
            }
        }
    });

    return redirect()
        ->route('product.index')
        ->with('success', 'Produk berhasil ditambahkan');
}


    /* ===============================
     * EDIT
     * =============================== */
    public function edit($id)
    {
        $product = Product::with('options.values')->findOrFail($id);
        $categories = DB::table('categories')->get();

        return view('pages.products.edit', compact('product', 'categories'));
    }

    /* ===============================
     * UPDATE
     * =============================== */
public function update(Request $request, $id)
{
    $product = Product::with('options.values')->findOrFail($id);

    $request->validate([
        'name' => 'required|min:3|unique:products,name,' . $product->id,
        'price' => 'required|string',
        'category_id' => 'required|exists:categories,id',
    ]);

    $this->validateOptions($request);

    DB::transaction(function () use ($request, $product) {

        // ===== Images =====
        $images = $product->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $images[] = $img->store('products', 'public');
            }
        }

        // ===== Update Product =====
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => (int) preg_replace('/\D/', '', $request->price),
            'category_id' => $request->category_id,
            'images' => $images,
            'is_best_seller' => $request->boolean('is_best_seller'),
            'is_custom' => $product->is_custom, // tetap pakai value lama
            'is_active' => $request->boolean('is_active'),
            'auto_select_all_custom' => $request->boolean('auto_select_all_custom'),
            'stock' => 0,
        ]);

        // ===== Hapus opsi yang dicentang delete =====
        if($request->filled('deleted_options')){
            ProductOption::whereIn('id', array_filter($request->deleted_options))->delete();
        }
            // ===== Process Options =====
            if ($request->options) {
                $autoAll = $request->boolean('auto_select_all_custom');

                foreach ($request->options as $opt) {
                    $option = null; // reset tiap iterasi

                    if (!empty($opt['id'])) {
                        // update opsi lama
                        $option = $product->options()->find($opt['id']);
                        if ($option) {
                            $option->update([
                                'name' => $opt['name'] ?? $option->name,
                                'type' => $opt['type'] ?? $option->type,
                                'is_required' => $autoAll ? 1 : ($opt['is_required'] ?? 0),
                            ]);
                        }
                    } else {
                        // opsi baru: baris kosong di-skip
                        if (blank($opt['name'] ?? null)) continue;

                        $option = $product->options()->create([
                            'name' => $opt['name'],
                            'type' => $opt['type'] ?? 'select',
                            'is_required' => $autoAll ? 1 : ($opt['is_required'] ?? 0),
                        ]);
                    }

                    if (!$option || empty($opt['values'])) continue;

                    foreach ($opt['values'] as $val) {
                        if (!empty($val['id'])) {
                            $value = $option->values()->find($val['id']);
                            if ($value) {
                                $value->update([
                                    'label' => $val['label'] ?? $value->label,
                                    'extra_price' => (int) preg_replace('/\D/', '', $val['extra_price'] ?? 0),
                                ]);
                            }
                        } elseif (!empty($val['label'])) {
                            $option->values()->create([
                                'label' => $val['label'],
                                'extra_price' => (int) preg_replace('/\D/', '', $val['extra_price'] ?? 0),
                            ]);
                        }
                    }
                }
            }

    });

    return redirect()->route('product.index')
        ->with('success', 'Produk berhasil diperbarui');
}


            private function validateOptions(Request $request): void
            {
                $errors = [];

                foreach ($request->input('options', []) as $i => $opt) {
                    $isExisting = !empty($opt['id']);
                    $name = trim($opt['name'] ?? '');
                    $values = collect($opt['values'] ?? []);

                    // value yang sudah disentuh (label atau harga terisi)
                    $touched = $values->filter(
                        fn ($v) => filled($v['label'] ?? null) || filled($v['extra_price'] ?? null)
                    );

                    // baris kosong total → aman, akan di-skip
                    if (!$isExisting && $name === '' && $touched->isEmpty()) continue;

                    if (!$isExisting && $name === '') {
                        $errors["options.$i.name"] = 'Nama opsi custom wajib diisi.';
                    }

                    if (!$isExisting && $touched->isEmpty()) {
                        $errors["options.$i.values"] = "Opsi \"$name\" minimal punya 1 value (label dan harga).";
                    }

                    foreach ($touched as $vi => $v) {
                        if (blank($v['label'] ?? null)) {
                            $errors["options.$i.values.$vi.label"] = 'Label value wajib diisi.';
                        }
                        if (blank($v['extra_price'] ?? null)) {
                            $errors["options.$i.values.$vi.extra_price"] = 'Harga tambahan wajib diisi (isi 0 jika gratis).';
                        }
                    }
                }

                if ($errors) {
                    throw \Illuminate\Validation\ValidationException::withMessages($errors);
                }
            }



    /* ===============================
     * DELETE IMAGE (AJAX) - JSON
     * =============================== */
    public function deleteImage(Request $request, $id, $index)
    {
        $product = Product::findOrFail($id);

        if (!isset($product->images[$index])) {
            return response()->json([
                'status' => false,
                'message' => 'Gambar tidak ditemukan.'
            ], 404);
        }

        $imgPath = $product->images[$index];

        if (Storage::disk('public')->exists($imgPath)) {
            Storage::disk('public')->delete($imgPath);
        }

        $images = $product->images;
        array_splice($images, $index, 1);
        $product->images = $images;
        $product->save();

        return response()->json([
            'status' => true,
            'message' => 'Gambar berhasil dihapus.'
        ]);
    }

    /* ===============================
     * DESTROY
     * =============================== */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus semua file gambar
        if ($product->images) {
            foreach ($product->images as $imgPath) {
                if (Storage::disk('public')->exists($imgPath)) {
                    Storage::disk('public')->delete($imgPath);
                }
            }
        }

        $product->options()->each(function ($opt) {
            $opt->values()->delete();
            $opt->delete();
        });

        $product->delete();

        return redirect()
            ->route('product.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}
