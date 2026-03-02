@extends('frontend.layouts.app')

@section('title', 'Gallery')

@section('content')
<div class="container py-5">

  {{-- Slider (pakai yang sudah ada) --}}
  @include('frontend.pages.beranda.components.slider', ['sliders' => $sliders])

  {{-- Judul --}}
  <div class="text-center my-5">
    <h2 class="fw-bold display-5">Gallery <span class="text-primary">WHS Konveksindo</span></h2>
    <p class="text-muted fs-5 text-center">Kumpulan dokumentasi produk & kegiatan kami</p>
  </div>

    {{-- Tombol Filter --}}
  <div class="d-flex justify-content-center flex-wrap mb-5">
    {{-- Tombol Semua --}}
    <a href="{{ route('frontend.gallery.index') }}"
       class="btn btn-outline-primary m-2 {{ request('title') ? '' : 'active' }}">
       Semua
    </a>

    {{-- Tombol semua judul gallery --}}
    @foreach($allGalleries as $gal)
      <a href="{{ route('frontend.gallery.index', ['title' => $gal->id]) }}"
         class="btn btn-outline-primary m-2 {{ request('title') == $gal->id ? 'active' : '' }}">
         {{ $gal->title }}
      </a>
    @endforeach
  </div>


{{-- <div class="d-flex justify-content-center flex-wrap mb-5">
    <a href="{{ route('frontend.gallery.index') }}"
       class="btn btn-outline-primary m-2 {{ request('title') ? '' : 'active' }}">
       Semua
    </a>
    @foreach($allGalleries as $gal)
      <a href="{{ route('frontend.gallery.index', ['title' => $gal->id]) }}"
         class="btn btn-outline-primary m-2 {{ request('title') == $gal->id ? 'active' : '' }}">
         {{ $gal->title }}
      </a>
    @endforeach
</div> --}}


  {{-- Grid per kategori + semua --}}
  @include('frontend.pages.gallery.components.grid', [
      'categories'   => $categories,
      'allGalleries' => $allGalleries ?? collect()
  ])
</div>


@endsection
