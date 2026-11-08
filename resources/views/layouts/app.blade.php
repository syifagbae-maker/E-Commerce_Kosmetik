
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'LuxSkin Beauty — Beauty, Your Way')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">

    @stack('styles')
</head>

<body>

    <div class="topline">
        ✨ BEAUTY DAYS — extra care, extra confidence.
        Gratis ongkir untuk transaksi tertentu.
    </div>

    <header class="header">

        <a class="logo" href="{{ route('home') }}">
            luxskin<span>.</span>
        </a>

        <nav aria-label="Navigasi utama">

            <a href="{{ route('home') }}">
                Home
            </a>

            <a href="{{ route('new-arrivals') }}">
                New Arrivals
            </a>

            <a href="{{ route('brands') }}">
                Brands
            </a>

            <a href="{{ route('categories') }}">
                Categories
            </a>

            <a href="{{ route('catalog', ['kategori' => 'skincare']) }}">
                Skincare
            </a>

            <a href="{{ route('catalog', ['kategori' => 'makeup']) }}">
                Makeup
            </a>

            <a href="{{ route('catalog', ['kategori' => 'body-care']) }}">
                Body Care
            </a>

            <a href="{{ route('promotions') }}">
                Promotions
            </a>

        </nav>

        <form class="search" action="{{ route('catalog') }}" method="GET">

            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari produk, brand, atau kebutuhanmu..."
                aria-label="Cari produk"
            >

            <button type="submit" aria-label="Cari">
                ⌕
            </button>

        </form>

        <div class="head-actions">

            <a href="{{ route('cart') }}" aria-label="Keranjang belanja">
                ♡ <small>Bag</small>
            </a>

            @if(session('user'))

                <a href="{{ route('orders') }}">
                    Akun
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="linkbtn">
                        Keluar
                    </button>
                </form>

            @else

                <a href="{{ route('login') }}">
                    Masuk
                </a>

            @endif

        </div>

    </header>

    @if(session('success'))
        <div class="flash success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="flash error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="flash error">
            {{ $errors->first() }}
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="footer">

        <div>

            <a class="logo" href="{{ route('home') }}">
                luxskin<span>.</span>
            </a>

            <p>
                Beauty essentials, thoughtfully curated.
                <br>
                Temukan ritual terbaik untuk dirimu.
            </p>

        </div>

        <div>

            <b>Explore</b>

            <a href="{{ route('home') }}">
                Home
            </a>

            <a href="{{ route('new-arrivals') }}">
                New Arrivals
            </a>

            <a href="{{ route('brands') }}">
                Brands
            </a>

            <a href="{{ route('categories') }}">
                Categories
            </a>

            <a href="{{ route('catalog') }}">
                Semua produk
            </a>

            <a href="{{ route('promotions') }}">
                Promotions
            </a>

        </div>

        <div>

            <b>Customer Care</b>

            <a href="{{ route('addresses') }}">
                Alamat saya
            </a>

            <a href="{{ route('orders') }}">
                Pesanan saya
            </a>

            <a href="{{ route('cart') }}">
                Keranjang
            </a>

        </div>

        <div>

            <b>Stay in the glow</b>

            <p>
                Ikuti kabar terbaru dan beauty deals dari LuxSkin.
            </p>

            <div class="newsletter">

                <input
                    type="email"
                    placeholder="Email kamu"
                    aria-label="Email kamu"
                >

                <button type="button" aria-label="Berlangganan">
                    →
                </button>

            </div>

        </div>

        <div class="copyright">
            © {{ date('Y') }} LuxSkin Beauty.
            Made for your everyday glow.
        </div>

    </footer>

    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')

</body>
</html>
