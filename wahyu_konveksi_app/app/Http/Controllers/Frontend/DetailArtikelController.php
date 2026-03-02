<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\NavigationMenu;
use App\Models\Comment;
use Illuminate\Http\Request;

class DetailArtikelController extends Controller
{
    /**
     * Detail artikel
     */
            public function show($slug)
            {
                $article = Article::with('images')->where('slug', $slug)->firstOrFail();

                // Tambah views
                $article->increment('views');

                // Menu navigasi
                $navigationMenus = NavigationMenu::orderBy('order', 'asc')->get();

                // Komentar yang disetujui
                $comments = Comment::where('article_id', $article->id)
                    ->where('is_approved', true)
                    ->latest()
                    ->get();

                // Latest posts
                $latestPosts = Article::where('is_published', true)
                    ->latest()
                    ->take(3)
                    ->get();

                // ✅ Ambil data keywords dari database
                $tags = [];
                if (!empty($article->keywords)) {
                    // Pisahkan berdasarkan koma, hilangkan spasi berlebih
                    $tags = array_map('trim', explode(',', $article->keywords));
                    // Batasi hanya 7 tag pertama
                    $tags = array_slice($tags, 0, 7);
                }

                return view('frontend.pages.detail_artikel.index', compact(
                    'article',
                    'navigationMenus',
                    'comments',
                    'latestPosts',
                    'tags'
                ));
            }


    /**
     * Simpan komentar
     */
    public function comment(Request $request, $id)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'article_id' => $id,
            'name'       => $request->name,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'is_approved'=> true,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dikirim!',
                'data'    => [
                    'name'    => $comment->name,
                    'rating'  => $comment->rating,
                    'comment' => $comment->comment,
                    'time'    => $comment->created_at->diffForHumans(),
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Komentar berhasil dikirim!');
    }
}
