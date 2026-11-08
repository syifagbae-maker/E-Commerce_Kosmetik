
@extends('layouts.app')

@section('title', 'Our Brands - LuxSkin')

@section('content')
<section class="section">
    <div class="section-heading">
        <span class="eyebrow">OUR COLLECTION</span>
        <h1>Explore Our Brands</h1>
        <p>Temukan berbagai brand kecantikan pilihan LuxSkin.</p>
    </div>

    <div class="brand-grid">
        @forelse($brands as $brand)
            <a href="{{ route('catalog', ['brand' => $brand->slug]) }}"
               class="brand-card">
                <div class="brand-logo">
                    <span>{{ $brand->nama_brand }}</span>
                </div>
                <div class="brand-button">Explore Collection</div>
            </a>
        @empty
            <p>Belum ada brand tersedia.</p>
        @endforelse
    </div>
</section>
@endsection
