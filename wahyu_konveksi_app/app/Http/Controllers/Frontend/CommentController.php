<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Simpan komentar artikel
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'article_id' => $id,
            'name'       => auth('customer')->user()->name,
            'email'      => auth('customer')->user()->email,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'is_approved'=> true, // atau false jika mau moderasi admin
        ]);

        return redirect()
            ->back()
            ->with('success', 'Komentar berhasil dikirim');
    }
}
