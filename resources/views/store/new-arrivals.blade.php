
@extends('layouts.app')

@section('title', 'New Arrivals - LuxSkin')

@section('content')
<section class="section">
    <div class="section-heading">
        <span class="eyebrow">JUST ARRIVED</span>
        <h1>New Arrivals</h1>
        <p>Temukan koleksi produk kecantikan terbaru dari LuxSkin.</p>
    </div>

    <div class="product-grid">
        @forelse($products as $p)
            @include('store._product')
        @empty
            <p>Belum ada produk terbaru.</p>
        @endforelse
    </div>

    <div class="pagination">
        {{ $products->links() }}
    </div>
</section>
@endsection
