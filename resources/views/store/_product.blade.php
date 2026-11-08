
<article class="product-card">

    <a class="product-photo" href="{{ route('product', $p->slug) }}">
        <img
            src="{{ !empty($p->path_gambar)
                ? asset('storage/' . ltrim($p->path_gambar, '/'))
                : 'https://images.unsplash.com/photo-1601049541289-9b1b7bbbfe19?w=700' }}"
            alt="{{ $p->nama_produk }}"
            loading="lazy"
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
