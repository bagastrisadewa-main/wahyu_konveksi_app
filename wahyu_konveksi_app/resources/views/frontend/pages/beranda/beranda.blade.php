@extends('frontend.layouts.app')

@section('title', 'Beranda')

@section('content')
  @include('frontend.pages.beranda.components.slider', ['sliders' => $sliders])
  @include('frontend.pages.beranda.components.about', ['about' => $about])
  @include('frontend.pages.beranda.components.keunggulan')
  @include('frontend.pages.beranda.components.kategori', ['categories' => $categories])
  @include('frontend.pages.beranda.components.products', ['products' => $products])
  @include('frontend.pages.beranda.components.keuntungan')
  @include('frontend.pages.beranda.components.review')
@endsection