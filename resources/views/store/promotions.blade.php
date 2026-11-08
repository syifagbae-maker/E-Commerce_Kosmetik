
@extends('layouts.app')

@section('title', 'Promotions - LuxSkin')

@section('content')
<section class="section">
    <div class="section-heading">
        <span class="eyebrow">SPECIAL OFFERS</span>
        <h1>Beauty Promotions</h1>
        <p>Nikmati penawaran spesial untuk produk kecantikan favoritmu.</p>
    </div>

    <div class="product-grid">
        @forelse($products as $product)
            @include('store._product')
        @empty
            <p>Belum ada produk promo saat ini.</p>
        @endforelse
    </div>

    {{ $products->links() }}
</section>
@endsection
