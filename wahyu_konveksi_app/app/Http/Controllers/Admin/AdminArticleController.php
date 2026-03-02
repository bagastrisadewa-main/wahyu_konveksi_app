<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminArticleController extends Controller
{



public function index(Request $request)
{
    $keyword = trim($request->title);
    $perPage = min((int) ($request->per_page ?? 10), 100);

    $query = Article::with('images')->latest();

    if ($keyword) {
        $query->where('title', 'LIKE', "%{$keyword}%");
    }

    $articles = $query->paginate($perPage)->appends($request->all());

    // Jika request AJAX, return JSON data
    if ($request->ajax()) {
        return response()->json([
            'data' => $articles->items(),
            'pagination' => [
                'total' => $articles->total(),
                'per_page' => $articles->perPage(),
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
            ]
        ]);
    }

    // Normal page load
    return view('pages.articles.index', compact('articles', 'keyword'));
}






    /**
     * Form create artikel
     */
    public function create()
    {
        $layouts = ['default', 'modern', 'magazine'];
        return view('pages.articles.create', compact('layouts'));
    }

    /**
     * 🆕 Utility: konversi link video ke embed
     */
    private function convertVideoLinks($content)
    {
        if (!$content) return $content;

        // YouTube
        $content = preg_replace(
            '/https?:\/\/(www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/i',
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/$2" frameborder="0" allowfullscreen></iframe>',
            $content
        );

        // Short link YouTube (youtu.be)
        $content = preg_replace(
            '/https?:\/\/youtu\.be\/([a-zA-Z0-9_-]+)/i',
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
            $content
        );

        // Vimeo
        $content = preg_replace(
            '/https?:\/\/(www\.)?vimeo\.com\/([0-9]+)/i',
            '<iframe width="560" height="315" src="https://player.vimeo.com/video/$2" frameborder="0" allowfullscreen></iframe>',
            $content
        );

        // TikTok
        $content = preg_replace(
            '/https?:\/\/(www\.)?tiktok\.com\/@[a-zA-Z0-9._]+\/video\/([0-9]+)/i',
            '<blockquote class="tiktok-embed" cite="$0" data-video-id="$2"><section></section></blockquote><script async src="https://www.tiktok.com/embed.js"></script>',
            $content
        );

        return $content;
    }

    /**
     * Simpan artikel baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'layout'           => 'required|string',
            'is_published'     => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'keywords'         => 'nullable|string|max:255',
            'images.*'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        // 🔄 Konversi otomatis link video ke embed iframe
        $content = $this->convertVideoLinks($request->content);

        $article = Article::create([
            'title'            => $request->title,
            'slug'             => Str::slug($request->title),
            'content'          => $content,
            'user_id'          => auth()->id() ?? 1,
            'layout'           => $request->layout,
            'is_published'     => $request->boolean('is_published'),
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'keywords'         => $request->keywords,
            'views'            => 0,
        ]);

        // simpan gambar multiple
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('articles', 'public');
                ArticleImage::create([
                    'article_id' => $article->id,
                    'image_path' => $path,
                    'caption'    => '',
                ]);
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan');
    }

    /**
     * Form edit artikel
     */
    public function edit($id)
    {
        $article = Article::with('images')->findOrFail($id);
        $layouts = ['default', 'modern', 'magazine'];
        return view('pages.articles.edit', compact('article', 'layouts'));
    }

    /**
     * Update artikel
     */
public function update(Request $request, $id)
{
    $article = Article::findOrFail($id);

    $request->validate([
        'title'            => 'required|string|max:255',
        'content'          => 'required|string',
        'layout'           => 'required|string',
        'is_published'     => 'nullable|in:0,1',
        'meta_title'       => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:500',
        'keywords'         => 'nullable|string|max:255',
        'images.*'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
    ]);

    // ✅ pastikan konten tidak null agar preg_replace tidak error
    $content = $this->convertVideoLinks($request->input('content', ''));

    // ✅ normalize is_published (bisa datang sebagai string '0' / '1')
    $isPublished = $request->input('is_published', 0);
    if ($isPublished === '1' || $isPublished === 1 || $isPublished === true) {
        $isPublished = 1;
    } else {
        $isPublished = 0;
    }

    // ✅ update artikel
    $article->update([
        'title'            => $request->title,
        'slug'             => Str::slug($request->title),
        'content'          => $content,
        'layout'           => $request->layout,
        'is_published'     => $isPublished,
        'meta_title'       => $request->meta_title,
        'meta_description' => $request->meta_description,
        'keywords'         => $request->keywords,
    ]);

    // ✅ upload gambar baru jika ada
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            if ($file->isValid()) {
                $path = $file->store('articles', 'public');
                ArticleImage::create([
                    'article_id' => $article->id,
                    'image_path' => $path,
                    'caption'    => '',
                ]);
            }
        }
    }

    return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui');
}



    /**
     * Hapus artikel + semua gambar terkait
     */

    public function destroy($id)
{
    $article = Article::with('images')->findOrFail($id);

    foreach ($article->images as $img) {
        if (Storage::disk('public')->exists($img->image_path)) {
            Storage::disk('public')->delete($img->image_path);
        }
        $img->delete();
    }

    $article->delete();

    // Jika request AJAX
    if(request()->ajax()){
        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dihapus'
        ]);
    }

    // Request biasa
    return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus');
}

    // public function destroy($id)
    // {
    //     $article = Article::with('images')->findOrFail($id);

    //     foreach ($article->images as $img) {
    //         if (Storage::disk('public')->exists($img->image_path)) {
    //             Storage::disk('public')->delete($img->image_path);
    //         }
    //         $img->delete();
    //     }

    //     $article->delete();

    //     return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus');
    // }

    /**
     * Hapus 1 gambar saja (AJAX)
     */
    public function destroyImage($id, $imageId)
    {
        $image = ArticleImage::where('article_id', $id)->where('id', $imageId)->firstOrFail();

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Upload gambar dari Summernote (AJAX)
     */
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('articles/summernote', 'public');
            return asset('storage/' . $path);
        }

        return response()->json(['error' => 'Upload gagal'], 422);
    }
}
