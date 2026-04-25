@extends('layouts.main')

@section('content')
@php
    $products = \App\Models\Product::with('category')->paginate(12);
    $categories = \App\Models\Category::all();
@endphp

<h2>Total produk: {{ $products->total() }}</h2>

@foreach($products as $product)
    <div style="border:1px solid #ccc; padding:10px; margin:10px;">
        <h3>{{ $product->name }}</h3>
        <p>Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        <p>Stok: {{ $product->stock }}</p>
        <p>Kategori: {{ $product->category->name }}</p>
    </div>
@endforeach

@endsection