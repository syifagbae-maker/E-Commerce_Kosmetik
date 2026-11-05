@extends('layouts.app')
@section('title',$product->nama_produk.' — LuxSkin')
@section('content')
<div class="breadcrumbs"><a href="{{ route('home') }}">Beranda</a> / <a href="{{ route('catalog') }}">Produk</a> / {{ $product->nama_produk }}</div>
<section class="product-detail">
    <div class="detail-image product-gallery">
        @if($images->isNotEmpty())
            <img class="gallery-main" src="{{ $images->first()->path_gambar }}" alt="{{ $images->first()->alt_text ?: $product->nama_produk }}">
            @if($images->count()>1)<div class="gallery-thumbs">@foreach($images as $image)<a href="{{ $image->path_gambar }}" target="_blank"><img src="{{ $image->path_gambar }}" alt="{{ $image->alt_text ?: $product->nama_produk }}"></a>@endforeach</div>@endif
        @else
            <img class="gallery-main" src="{{ asset('images/products/vanilla-cloud-body-wash.svg') }}" alt="{{ $product->nama_produk }}">
        @endif
    </div>
    <div class="detail-copy"><span class="eyebrow">{{ $product->nama_brand }} · {{ $product->nama_kategori }}</span><h1>{{ $product->nama_produk }}</h1><div class="detail-price">Rp{{ number_format($product->harga,0,',','.') }} @if($product->harga_coret)<del>Rp{{ number_format($product->harga_coret,0,',','.') }}</del>@endif</div><p>{{ $product->deskripsi }}</p><div class="detail-meta"><span>SKU</span><b>{{ $product->sku }}</b><span>Jenis kulit</span><b>{{ $product->jenis_kulit ?: 'Semua jenis kulit' }}</b><span>Berat</span><b>{{ $product->berat_gram }} gr</b><span>Stok</span><b>{{ $product->jumlah_stok ?? 0 }} item</b></div><form class="buy-form" method="POST" action="{{ route('cart.add',$product->id_produk) }}">@csrf<label>Jumlah <input type="number" name="jumlah" min="1" max="20" value="1"></label><button class="btn dark">Tambah ke keranjang ↗</button></form><div class="accordion"><details open><summary>Manfaat produk</summary><p>{{ $product->manfaat ?: $product->deskripsi }}</p></details><details><summary>Cara pakai</summary><p>{{ $product->cara_pakai ?: 'Gunakan sesuai kebutuhan dan petunjuk pada kemasan.' }}</p></details><details><summary>Komposisi</summary><p>{{ $product->komposisi ?: 'Informasi komposisi dapat dilihat pada kemasan produk.' }}</p></details></div></div>
</section>
<section class="section"><span class="eyebrow">ULASAN PELANGGAN</span><h2>Ulasan produk</h2>@forelse($reviews as $review)<div class="review"><b>{{ $review->nama }} · {{ str_repeat('★',$review->rating) }}</b><p>{{ $review->komentar }}</p></div>@empty<p class="muted">Belum ada ulasan untuk produk ini.</p>@endforelse</section>
@endsection
