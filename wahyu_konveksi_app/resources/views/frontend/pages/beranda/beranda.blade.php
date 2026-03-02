@extends('frontend.layouts.app')

@section('title', 'Beranda')

@section('content')
  {{-- Slider --}}
  @include('frontend.pages.beranda.components.slider', ['sliders' => $sliders])

  {{-- About Us --}}
  @include('frontend.pages.beranda.components.about', ['about' => $about])


    {{-- Keunggulan --}}
  @include('frontend.pages.beranda.components.keunggulan')

        {{-- kategori --}}
  @include('frontend.pages.beranda.components.kategori', ['categories' => $categories])

  {{-- Produk Unggulan --}}
@include('frontend.pages.beranda.components.products', ['products' => $products])

      {{-- Keuntungan --}}
  @include('frontend.pages.beranda.components.keuntungan')

{{-- Review Pelanggan --}}
@include('frontend.pages.beranda.components.review')


@endsection
