
@extends('layouts.app')

@section('title', 'Categories - LuxSkin')

@section('content')
<section class="section">
    <div class="section-heading">
        <span class="eyebrow">SHOP BY CATEGORY</span>
        <h1>Explore Categories</h1>
        <p>Pilih kategori produk kecantikan favoritmu.</p>
    </div>

    <div class="category-grid">
        @forelse($categories as $category)
            <a href="{{ route('catalog', ['kategori' => $category->slug]) }}"
               class="category-tile">
                <h3>{{ $category->nama_kategori }}</h3>
                <span>Explore Collection →</span>
            </a>
        @empty
            <p>Belum ada kategori tersedia.</p>
        @endforelse
    </div>
</section>
@endsection
