@php
    $gambar = $p->path_gambar ?? null;

    if ($gambar) {
        $gambar = ltrim($gambar, '/');

        if (!str_starts_with($gambar, 'http://') &&
            !str_starts_with($gambar, 'https://')) {

            if (str_starts_with($gambar, 'storage/')) {
                $gambarUrl = asset($gambar);
            } elseif (str_starts_with($gambar, 'images/')) {
                $gambarUrl = asset($gambar);
            } else {
                $gambarUrl = asset('storage/' . $gambar);
            }

        } else {
            $gambarUrl = $gambar;
        }
    } else {
        $gambarUrl = 'https://images.unsplash.com/photo-1601049541289-9b1b7bbbfe19?w=700';
    }
@endphp

<article class="product-card">

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
    </a>

    <div class="product-info">

        <small>
            {{ $p->nama_brand ?? 'LUXSKIN' }}
            @if(!empty($p->nama_kategori))
                · {{ $p->nama_kategori }}
            @endif
        </small>

        <a class="pname" href="{{ route('product', $p->slug) }}">
            {{ $p->nama_produk }}
        </a>

        <div class="price">
            Rp{{ number_format($p->harga, 0, ',', '.') }}

            @if(!empty($p->harga_coret) && $p->harga_coret > $p->harga)
                <del>
                    Rp{{ number_format($p->harga_coret, 0, ',', '.') }}
                </del>
            @endif
        </div>

        <form method="POST" action="{{ route('cart.add', $p->id_produk) }}">
            @csrf
            <button type="submit" class="add-btn">
                + Add to Bag
            </button>
        </form>

    </div>

</article>