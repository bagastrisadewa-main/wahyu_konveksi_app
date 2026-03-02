@extends('frontend.layouts.app')

@section('title', 'Kategori Produk')

@section('content')
    {{-- Slider --}}
    @include('frontend.pages.beranda.components.slider', ['sliders' => $sliders])

    {{-- Component kategori --}}
    @include('frontend.pages.beranda.components.kategori', ['categories' => $categories])
@endsection
