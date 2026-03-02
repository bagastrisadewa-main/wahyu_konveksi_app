@extends('frontend.layouts.app')

@section('title', $article->title)

@section('content')
<div class="container py-5">
    @include('frontend.pages.detail_artikel.components.detail', [
        'article' => $article,
        'navigationMenus' => $navigationMenus,
        'comments' => $comments,
        'latestPosts' => $latestPosts,
        'tags' => $tags
    ])
</div>
@endsection
