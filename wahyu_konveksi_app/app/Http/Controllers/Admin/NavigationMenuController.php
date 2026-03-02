<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NavigationMenuController extends Controller
{

public function index(Request $request)
{
    $query = NavigationMenu::with('parent');

    // Filter by title
    $title = $request->input('title', null);
    if ($title && trim($title) !== '') {
        $query->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower(trim($title)) . '%']);
    }

    $perPage = $request->input('per_page', 10);

    $menus = $query->orderBy('order', 'asc')->paginate($perPage);

    // Jika request AJAX, kirim JSON murni
    if ($request->ajax()) {
        return response()->json([
            'data' => $menus->items(),
            'pagination' => [
                'total' => $menus->total(),
                'per_page' => $menus->perPage(),
                'current_page' => $menus->currentPage(),
                'last_page' => $menus->lastPage(),
            ]
        ]);
    }

    return view('pages.menu_nav.index', ['navigationMenus' => $menus]);
}



        // public function index(Request $request)
        // {
        //     \Log::info('NAV SEARCH DEBUG', $request->all());
        //     \Log::info('SEARCH REQUEST', $request->all());
        //     // \Log::info('QUERY SQL', [$query->toSql(), $query->getBindings()]);

        //     // 🔴 WAJIB eager load
        //     $query = NavigationMenu::with('parent');

        //     if ($request->filled('title')) {
        //         \Log::info('FILTER TITLE', ['title' => $request->title]);

        //         $query->where('title', 'LIKE', '%' . $request->title . '%');
        //     }

        //     $navigationMenus = $query
        //         ->orderBy('order', 'asc')
        //         ->paginate($request->per_page ?? 10);

        //     if ($request->ajax()) {
        //         return response()->json([
        //             'html' => view('pages.menu_nav.partials.table', compact('navigationMenus'))->render()
        //         ]);
        //     }

        //     return view('pages.menu_nav.index', compact('navigationMenus'));
        // }



        // public function index(Request $request)
        // {
        //     $query = NavigationMenu::query();

        //     // Filter hanya jika ada input title
        //     if ($request->has('title') && !empty($request->title)) {
        //         $query->where('title', 'like', '%' . $request->title . '%');
        //     }

        //     $navigationMenus = $query->orderBy('order', 'asc')
        //         ->paginate($request->per_page ?? 10);

        //     // Jika request Ajax, render partial table
        //     if ($request->ajax()) {
        //         return response()->json([
        //             'html' => view('pages.menu_nav.partials.table', compact('navigationMenus'))->render()
        //         ]);
        //     }

        //     return view('pages.menu_nav.index', compact('navigationMenus'));
        // }



// public function index(Request $request)
// {
//     $navigationMenus = NavigationMenu::query()->orderBy('order');

//     // 🔍 Live search
//     if ($request->filled('title')) {
//         $navigationMenus->where('title', 'like', '%' . $request->title . '%');
//     }
//     // 📄 Per page
//     $perPage = $request->per_page ?? 10;
//     $navigationMenus = $navigationMenus->paginate($perPage)
//         ->appends($request->only(['title', 'per_page']));

//     // 🔄 AJAX response
//     if ($request->ajax()) {
//         return response()->json([
//             'html' => view('pages.menu_nav.partials.table', compact('navigationMenus'))->render()
//         ]);
//     }

//     // normal load
//     return view('pages.menu_nav.index', compact('navigationMenus'));
// }


    public function create()
    {
        $parents = NavigationMenu::whereNull('parent_id')->orderBy('order')->get();
        return view('pages.menu_nav.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:150',
            'slug'        => 'nullable|string|max:200|unique:navigation_menus,slug',
            'url'         => 'nullable|string|max:255',
            'type'        => 'required|in:internal,external',
            'parent_id'   => 'nullable|exists:navigation_menus,id',
            'order'       => 'required|integer',
            'icon'        => 'nullable|string|max:100',
            'active'      => 'required|boolean',
            'open_in_new_tab' => 'sometimes|boolean',
        ]);

        $slug = $request->input('slug') ?: Str::slug($request->input('title'));
        $original = $slug;
        $i = 1;
        while (NavigationMenu::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i++;
        }

        $data = $request->only(['title','url','type','parent_id','order','icon']);
        $data['slug'] = $slug;
        $data['active'] = $request->boolean('active');
        $data['open_in_new_tab'] = $request->has('open_in_new_tab') ? 1 : 0;

        NavigationMenu::create($data);

        return redirect()->route('navigation-menus.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function show(NavigationMenu $navigationMenu)
    {
        return redirect()->route('navigation-menus.edit', $navigationMenu);
    }

    public function edit(NavigationMenu $navigationMenu)
    {
        $parents = NavigationMenu::whereNull('parent_id')
            ->where('id', '<>', $navigationMenu->id)
            ->orderBy('order')
            ->get();

        return view('pages.menu_nav.edit', compact('navigationMenu','parents'));
    }

    public function update(Request $request, NavigationMenu $navigationMenu)
    {
        $request->validate([
            'title'       => 'required|string|max:150',
            'slug'        => 'nullable|string|max:200|unique:navigation_menus,slug,' . $navigationMenu->id,
            'url'         => 'nullable|string|max:255',
            'type'        => 'required|in:internal,external',
            'parent_id'   => 'nullable|exists:navigation_menus,id',
            'order'       => 'required|integer',
            'icon'        => 'nullable|string|max:100',
            'active'      => 'required|boolean',
            'open_in_new_tab' => 'sometimes|boolean',
        ]);

        $slug = $request->input('slug') ?: Str::slug($request->input('title'));
        $original = $slug;
        $i = 1;
        while (NavigationMenu::where('slug', $slug)
            ->where('id','<>',$navigationMenu->id)
            ->exists()) {
            $slug = $original . '-' . $i++;
        }

        $data = $request->only(['title','url','type','parent_id','order','icon']);
        $data['slug'] = $slug;
        $data['active'] = $request->boolean('active');
        $data['open_in_new_tab'] = $request->has('open_in_new_tab') ? 1 : 0;

        $navigationMenu->update($data);

        return redirect()->route('navigation-menus.index')
            ->with('success','Menu berhasil diperbarui.');
    }

public function destroy(NavigationMenu $navigationMenu, Request $request)
{
    try {
        $navigationMenu->delete();

        // Jika request AJAX, kembalikan JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil dihapus.'
            ]);
        }

        // Fallback normal (redirect)
        return redirect()->route('navigation-menus.index')
            ->with('success', 'Menu berhasil dihapus.');

    } catch (\Exception $e) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus menu.'
            ], 500);
        }

        return redirect()->route('navigation-menus.index')
            ->with('error', 'Gagal menghapus menu.');
    }
}

}
