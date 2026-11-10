
@php
    // ==========================================
    // GAMBAR PRODUK
    // ==========================================

    $gambar = $p->path_gambar ?? null;

    if (!empty($gambar)) {
        $gambar = ltrim($gambar, '/');

        // Gambar dari URL eksternal
        if (
            str_starts_with($gambar, 'http://') ||
            str_starts_with($gambar, 'https://')
        ) {
            $gambarUrl = $gambar;
        } else {
            // Gambar dari folder public
            if (
                str_starts_with($gambar, 'storage/') ||
                str_starts_with($gambar, 'images/')
            ) {
                $gambarUrl = asset($gambar);
            } else {
                $gambarUrl = asset('storage/' . $gambar);
            }
        }
    } else {
        // Gambar default
        $gambarUrl = 'https://images.unsplash.com/photo-1601049541289-9b1b7bbbfe19?w=700';
    }

    // ==========================================
    // STOK PRODUK
    // ==========================================

    $stokTersedia = $p->jumlah_stok ?? null;

    $stokHabis = $stokTersedia !== null && $stokTersedia < 1;
@endphp

<article class="product-card">

    {{-- GAMBAR PRODUK --}}
    <a class="product-photo" href="{{ route('product', $p->slug) }}">

        <img
            src="{{ $gambarUrl }}"
            alt="{{ $p->nama_produk }}"
            loading="lazy"
            onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1601049541289-9b1b7bbbfe19?w=700';"
        >

        @if(!empty($p->harga_coret) && $p->harga_coret > $p->harga)
            <span class="tag">SALE</span>
        @else
            <span class="tag">BEST PICK</span>
        @endif

        @if($stokHabis)
            <span class="tag out-of-stock">SOLD OUT</span>
        @endif

    </a>

    {{-- INFORMASI PRODUK --}}
    <div class="product-info">

        {{-- BRAND DAN KATEGORI --}}
        <small>
            {{ $p->nama_brand ?? 'LUXSKIN' }}

            @if(!empty($p->nama_kategori))
                · {{ $p->nama_kategori }}
            @endif
        </small>

        {{-- NAMA PRODUK --}}
        <a class="pname" href="{{ route('product', $p->slug) }}">
            {{ $p->nama_produk }}
        </a>

        {{-- HARGA PRODUK --}}
        <div class="price">

            Rp{{ number_format($p->harga, 0, ',', '.') }}

            @if(!empty($p->harga_coret) && $p->harga_coret > $p->harga)
                <del>
                    Rp{{ number_format($p->harga_coret, 0, ',', '.') }}
                </del>
            @endif

        </div>

        {{-- FORM ADD TO BAG --}}
        <form
            method="POST"
            action="{{ route('cart.add', $p->id_produk) }}"
            class="add-to-bag-form"
            data-cart-add
        >

            @csrf

            <input
                type="hidden"
                name="jumlah"
                value="1"
            >

            <button
                type="submit"
                class="add-btn"
                @if($stokHabis) disabled @endif
            >
                @if($stokHabis)
                    OUT OF STOCK
                @else
                    + ADD TO BAG
                @endif
            </button>

        </form>

    </div>

</article>
