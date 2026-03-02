@extends('frontend.layouts.app')

@section('title', 'Artikel')

@section('content')
<div class="container py-5">

    {{-- Slider (pakai slider beranda jika ada) --}}
    @if(View::exists('frontend.pages.beranda.components.slider'))
        @include('frontend.pages.beranda.components.slider', ['sliders' => $sliders])
    @endif

    {{-- Judul halaman --}}
    <div class="text-center my-5">
        <h2 class="fw-bold display-5">Artikel <span class="text-primary">WHS Konveksindo</span></h2>
        <p class="text-muted fs-5 text-center">Berita, informasi, dan update terbaru</p>
    </div>

    {{-- Pilih layout sesuai request, fallback ke default --}}
    @php
        $layoutView = 'frontend.pages.artikel.components.' . $layout;
        if(!View::exists($layoutView)) {
            $layoutView = 'frontend.pages.artikel.components.default';
        }
    @endphp

    @include($layoutView, ['articles' => $articles])

    {{-- Pagination --}}
    @if(method_exists($articles, 'links'))
    <div class="d-flex justify-content-center mt-5">
        {{ $articles->links() }}
    </div>
    @endif

</div>
@endsection
