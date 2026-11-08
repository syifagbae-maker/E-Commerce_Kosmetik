
@extends('layouts.app')

@section('title', 'LuxSkin Beauty — Beauty, Your Way')

@section('content')

    {{-- HERO BANNER --}}
    <section class="hero">
        <div class="hero-copy">
            <span class="eyebrow">WELCOME TO LUXSKIN BEAUTY</span>

            <h1>
                Discover your<br>
                <em>beauty essentials.</em>
            </h1>

            <p>
                Temukan skincare, makeup, dan body care pilihan
                untuk menemani setiap rutinitas kecantikanmu.
                Semua kebutuhan beauty dalam satu tempat.
            </p>

            <a class="btn dark" href="{{ route('catalog') }}">
                Explore Products <span>↗</span>
            </a>

            <div class="hero-note">
                ✦ Beauty essentials · Curated with care
            </div>
        </div>

        <div class="hero-image">
            <img
                src="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=1200"
                alt="Koleksi skincare dan produk kecantikan"
            >

            <div class="floating-card">
                <b>THE BEAUTY EDIT</b>
                <span>
                    Discover your<br>
                    everyday glow.
                </span>
            </div>
        </div>
    </section>


    {{-- BENEFITS --}}
    <section class="benefits">

        <div>
            ♡
            <span>
                <b>Beauty Essentials</b>
                <small>Produk pilihan untukmu</small>
            </span>
        </div>

        <div>
            ✧
            <span>
                <b>Favourite Brands</b>
                <small>Brand kecantikan pilihan</small>
            </span>
        </div>

        <div>
            ↗
            <span>
                <b>Easy Shopping</b>
                <small>Belanja praktis dan nyaman</small>
            </span>
        </div>

        <div>
            ♧
            <span>
                <b>Customer Care</b>
                <small>Kami siap membantu</small>
            </span>
        </div>

    </section>


    {{-- SHOP BY CATEGORY --}}
    <section class="section" id="categories">

        <div class="section-head">
            <div>
                <span class="eyebrow">FIND YOUR BEAUTY NEEDS</span>

                <h2>
                    Shop by <em>Category.</em>
                </h2>

                <p>
                    Temukan produk sesuai kebutuhan kecantikanmu.
                </p>
            </div>

            <a class="text-link" href="{{ route('catalog') }}">
                View all ↗
            </a>
        </div>

        <div class="category-grid">

            @forelse ($categories as $i => $cat)

                <a
                    class="category-tile tile-{{ $i % 5 }}"
                    href="{{ route('catalog', ['kategori' => $cat->slug]) }}"
                >
                    <span>
                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <h3>{{ $cat->nama_kategori }}</h3>

                    <small>Discover now ↗</small>
                </a>

            @empty

                <p>Belum ada kategori produk tersedia.</p>

            @endforelse

        </div>

    </section>


    {{-- POPULAR BRANDS --}}
    @if(isset($brands) && $brands->count() > 0)

        <section class="section brands-section" id="our-brands">

            <div class="section-head">
                <div>
                    <span class="eyebrow">EXPLORE YOUR FAVOURITES</span>

                    <h2>
                        Popular <em>Brands.</em>
                    </h2>

                    <p>
                        Kenali berbagai brand kecantikan favoritmu.
                    </p>
                </div>

                <a class="text-link" href="{{ route('catalog') }}">
                    Explore all ↗
                </a>
            </div>

            <div class="brand-grid">

                @foreach ($brands as $brand)

                    <a
                        href="{{ route('catalog', ['brand' => $brand->slug]) }}"
                        class="brand-card"
                    >

                        <div class="brand-logo">

                            @if (!empty($brand->logo))

                                <img
                                    src="{{ asset('storage/' . ltrim($brand->logo, '/')) }}"
                                    alt="{{ $brand->nama_brand }}"
                                    loading="lazy"
                                >

                            @else

                                <span>{{ $brand->nama_brand }}</span>

                            @endif

                        </div>

                        <h3>{{ $brand->nama_brand }}</h3>

                        <span class="brand-button">
                            Shop Brand ↗
                        </span>

                    </a>

                @endforeach

            </div>

        </section>

    @endif


    {{-- NEW ARRIVALS / PRODUCTS --}}
    <section class="section" id="new-arrivals">

        <div class="section-head">
            <div>
                <span class="eyebrow">DISCOVER YOUR NEXT FAVOURITE</span>

                <h2>
                    Latest <em>Beauty Picks.</em>
                </h2>

                <p>
                    Pilihan produk kecantikan untuk melengkapi
                    rutinitas sehari-harimu.
                </p>
            </div>

            <a class="text-link" href="{{ route('catalog') }}">
                Shop all products ↗
            </a>
        </div>

        <div class="product-grid">

            @forelse ($products as $p)

                @include('store._product', ['p' => $p])

            @empty

                <p>Belum ada produk yang tersedia.</p>

            @endforelse

        </div>

    </section>


    {{-- BEAUTY CAMPAIGN --}}
    <section class="campaign" id="promotions">

        <div>
            <span class="eyebrow">YOUR BEAUTY MOMENT</span>

            <h2>
                Make every day<br>
                a <em>glow day.</em>
            </h2>

            <p>
                Temukan produk kecantikan yang sesuai dengan
                kebutuhan dan gaya hidupmu.
            </p>

            <a class="btn light" href="{{ route('catalog') }}">
                Discover More ↗
            </a>
        </div>

        <img
            src="https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?w=900"
            alt="Koleksi produk skincare dan kecantikan"
            loading="lazy"
        >

    </section>


    {{-- REGISTER BANNER --}}
    <section class="ad-banner">

        <div>
            <span class="eyebrow">WELCOME TO LUXSKIN</span>

            <h2>
                Your beauty journey<br>
                starts <em>here.</em>
            </h2>

            <p>
                Bergabung bersama LuxSkin dan temukan berbagai
                produk kecantikan favoritmu.
            </p>

            <a class="btn dark" href="{{ route('register') }}">
                Create Account ↗
            </a>
        </div>

        <div class="ad-stamp">
            LOVE<br>
            YOUR<br>
            GLOW
        </div>

    </section>

    
<!-- LUXSKIN PROMO POPUP -->
<div id="luxPromoPopup" class="lux-popup-overlay">

    <div class="lux-popup-container">

        <!-- Tombol Close -->
        <button type="button"
                class="lux-popup-close"
                id="closeLuxPopup">
            &times;
        </button>

        <!-- Banner Promosi -->
        <a href="{{ route('catalog') }}" class="lux-popup-link">
           <img
    src="{{ asset('images/promotions/promo-popup.png') }}"
    alt="Promo LuxSkin"
    class="lux-popup-image">
        </a>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const popup = document.getElementById('luxPromoPopup');
    const closeBtn = document.getElementById('closeLuxPopup');

    if (!popup || !closeBtn) return;

    // Cek apakah popup sudah ditutup
    if (!sessionStorage.getItem('luxPromoClosed')) {

        setTimeout(function () {
            popup.classList.add('active');
            document.body.style.overflow = 'hidden';
        }, 800);

    }

    // Fungsi menutup popup
    function closePopup() {

        popup.classList.remove('active');
        document.body.style.overflow = '';

        sessionStorage.setItem('luxPromoClosed', 'true');

    }

    // Tombol silang
    closeBtn.addEventListener('click', closePopup);

    // Klik area luar popup
    popup.addEventListener('click', function (event) {

        if (event.target === popup) {
            closePopup();
        }

    });

    // Tombol ESC
    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape' &&
            popup.classList.contains('active')) {

            closePopup();

        }

    });

});
</script>


@endsection
