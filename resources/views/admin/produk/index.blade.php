
@extends('adminlte::page')

@section('title', 'Kelola Produk LuxSkin')

@section('content_header')
@stop

@section('content')
<div class="lux-products">

    <div class="lux-topbar">
        <div class="lux-heading">
            <div class="lux-eyebrow">LUXSKIN BEAUTY STUDIO</div>
            <h1>Kelola Produk</h1>
            <p>Atur katalog produk kecantikan LuxSkin dalam satu tempat.</p>
        </div>

        <div class="lux-date-card">
            <div class="lux-date-symbol"><span>L</span></div>
            <div class="lux-date-info">
                <div class="lux-date-label">HARI INI</div>
                <div id="lux-date" class="lux-date-value">Memuat tanggal...</div>
                <div id="lux-clock" class="lux-clock">--:-- WIB</div>
            </div>
        </div>
    </div>

    <section class="lux-hero">
        <div class="lux-hero-content">
            <div class="lux-hero-label">PRODUCT MANAGEMENT</div>
            <h2>Curated Beauty Collection.</h2>
            <p>Kelola informasi, harga, kategori, brand, dan status produk agar katalog LuxSkin selalu tertata.</p>
            <a href="#daftar-produk" class="lux-primary-btn">LIHAT DAFTAR PRODUK <span>↓</span></a>
        </div>
        <div class="lux-hero-decoration" aria-hidden="true">
            <div class="lux-orbit lux-orbit-one"></div>
            <div class="lux-orbit lux-orbit-two"></div>
            <div class="lux-decoration-center">L</div>
            <div class="lux-decoration-caption">LUXSKIN<br>COLLECTION</div>
        </div>
    </section>

    <div class="lux-section-heading">
        <div>
            <span class="lux-section-kicker">RINGKASAN KATALOG</span>
            <h3>Product Overview</h3>
        </div>
        <span class="lux-live-label">
            <span class="lux-live-dot"></span>
            DATA PRODUK
        </span>
    </div>

    <div class="lux-stats-grid">
        <div class="lux-stat-card stat-pink">
            <div class="lux-stat-top">
                <span class="lux-stat-label">Total Produk</span>
                <div class="lux-stat-icon"><i class="fas fa-box-open"></i></div>
            </div>
            <div class="lux-stat-number">{{ number_format($totalProduk ?? 0, 0, ',', '.') }}</div>
            <div class="lux-stat-description">Semua produk terdaftar</div>
            <div class="lux-stat-line"></div>
        </div>

        <div class="lux-stat-card stat-green">
            <div class="lux-stat-top">
                <span class="lux-stat-label">Produk Aktif</span>
                <div class="lux-stat-icon"><i class="fas fa-check-circle"></i></div>
            </div>
            <div class="lux-stat-number">{{ number_format($produkAktif ?? 0, 0, ',', '.') }}</div>
            <div class="lux-stat-description">Produk berstatus aktif</div>
            <div class="lux-stat-line"></div>
        </div>

        <div class="lux-stat-card stat-gold">
            <div class="lux-stat-top">
                <span class="lux-stat-label">Produk Draft</span>
                <div class="lux-stat-icon"><i class="fas fa-file-alt"></i></div>
            </div>
            <div class="lux-stat-number">{{ number_format($produkDraft ?? 0, 0, ',', '.') }}</div>
            <div class="lux-stat-description">Produk berstatus draft</div>
            <div class="lux-stat-line"></div>
        </div>
    </div>

    <section class="lux-panel" id="daftar-produk">
        @if(session('success'))
            <div class="lux-success-message">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="lux-panel-header">
            <div>
                <span class="lux-panel-kicker">INVENTARIS KATALOG</span>
                <h3>Daftar Produk</h3>
                <p>Cari dan periksa informasi produk yang tersimpan.</p>
            </div>
            <div class="lux-panel-actions">
                <span class="lux-count-label">{{ $produk->total() }} PRODUK</span>
                <a href="{{ route('admin.produk.create') }}" class="lux-add-button">
                    <i class="fas fa-plus"></i>
                    TAMBAH PRODUK
                </a>
            </div>
        </div>

        <div class="lux-toolbar">
            <form action="{{ url('/admin/produk') }}" method="GET" class="lux-search-form">
                <label for="cari-produk" class="lux-search-label">CARI PRODUK</label>
                <div class="lux-search-control">
                    <i class="fas fa-search"></i>
                    <input
                        type="text"
                        id="cari-produk"
                        name="cari"
                        value="{{ request('cari') }}"
                        placeholder="Cari nama produk atau SKU..."
                    >
                    @if(request('cari'))
                        <a href="{{ url('/admin/produk') }}" class="lux-clear-search">RESET</a>
                    @endif
                    <button type="submit" class="lux-search-button">CARI</button>
                </div>
            </form>

            <div class="lux-toolbar-note">
                Menampilkan {{ $produk->firstItem() ?? 0 }}–{{ $produk->lastItem() ?? 0 }}
                dari {{ $produk->total() }} produk
            </div>
        </div>

        <div class="table-responsive">
            <table class="table lux-table">
                <thead>
                    <tr>
                        <th>PRODUK</th>
                        <th>SKU</th>
                        <th>KATEGORI</th>
                        <th>BRAND</th>
                        <th>HARGA</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produk as $item)
                        <tr>
                            <td>
                                <div class="lux-product-cell">
                                    <div class="lux-product-monogram">L</div>
                                    <div class="lux-product-info">
                                        <strong>{{ $item->nama_produk }}</strong>
                                        <small>
                                            ID PRODUK: {{ $item->id_produk }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="lux-sku">
                                    {{ $item->sku ?: '—' }}
                                </span>
                            </td>

                            <td>
                                <span class="lux-category">
                                    {{ $item->nama_kategori ?: 'Belum diatur' }}
                                </span>
                            </td>

                            <td>
                                <span class="lux-brand">
                                    {{ $item->nama_brand ?: 'Belum diatur' }}
                                </span>
                            </td>

                            <td>
                                <div class="lux-price">
                                    Rp{{ number_format($item->harga ?? 0, 0, ',', '.') }}
                                </div>
                                @if(!empty($item->harga_coret) && $item->harga_coret > $item->harga)
                                    <div class="lux-old-price">
                                        Rp{{ number_format($item->harga_coret, 0, ',', '.') }}
                                    </div>
                                @endif
                            </td>

                            <td>
                                @if(strtolower($item->status ?? '') === 'aktif')
                                    <span class="lux-status status-active">
                                        <span class="lux-status-dot"></span> AKTIF
                                    </span>
                                @elseif(strtolower($item->status ?? '') === 'draft')
                                    <span class="lux-status status-draft">
                                        <span class="lux-status-dot"></span> DRAFT
                                    </span>
                                @else
                                    <span class="lux-status status-other">
                                        {{ strtoupper($item->status ?? 'BELUM DIATUR') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="lux-empty-state">
                                    <div class="lux-empty-icon"><i class="fas fa-box-open"></i></div>
                                    @if(request('cari'))
                                        <h4>Produk Tidak Ditemukan</h4>
                                        <p>Tidak ada produk yang cocok dengan pencarian "{{ request('cari') }}".</p>
                                        <a href="{{ url('/admin/produk') }}" class="lux-empty-link">
                                            TAMPILKAN SEMUA PRODUK →
                                        </a>
                                    @else
                                        <h4>Katalog Masih Kosong</h4>
                                        <p>Belum ada produk yang tersimpan di katalog LuxSkin.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($produk->hasPages())
            <div class="lux-pagination">
                <div class="lux-pagination-info">
                    HALAMAN {{ $produk->currentPage() }} DARI {{ $produk->lastPage() }}
                </div>
                <div class="lux-pagination-links">
                    {{ $produk->links() }}
                </div>
            </div>
        @endif
    </section>

    <div class="lux-bottom-banner">
        <div class="lux-bottom-mark">L</div>
        <div class="lux-bottom-copy">
            <span>LUXSKIN BEAUTY STUDIO</span>
            <h3>Every Product Tells a Beauty Story.</h3>
            <p>Pastikan informasi produk selalu jelas, akurat, dan mudah ditemukan.</p>
        </div>
        <a href="{{ url('/admin') }}" class="lux-bottom-link">KEMBALI KE DASHBOARD →</a>
    </div>

    <div class="lux-footer">
        <span>© {{ date('Y') }} LUXSKIN BEAUTY STUDIO</span>
        <span>PRODUCT MANAGEMENT</span>
    </div>
</div>
@stop

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@600;700;800;900;1000&family=Playfair+Display:wght@700;800;900&display=swap');

:root {
    --pink:#e83e80;
    --pink-dark:#c92768;
    --ink:#30212b;
    --muted:#8f7e89;
    --border:#f1e5eb;
}

.content-wrapper { background:#fff8fb !important; }
.content { padding:24px 25px 35px !important; }

.lux-products,.lux-products * { box-sizing:border-box; }
.lux-products {
    color:var(--ink);
    font-family:'Nunito Sans','Segoe UI',sans-serif !important;
    font-weight:800;
    -webkit-font-smoothing:antialiased;
}
.lux-products p,.lux-products a,.lux-products td,
.lux-products th,.lux-products small,.lux-products span {
    font-family:'Nunito Sans','Segoe UI',sans-serif;
}

/* SIDEBAR LUXSKIN — CLEAN, BOLD, PREMIUM */
body .wrapper .main-sidebar,
body .main-sidebar,
.main-sidebar {
    background:linear-gradient(180deg,#ffffff 0%,#fffafd 58%,#fff4f8 100%) !important;
    border-right:1px solid #f1dce6 !important;
    box-shadow:5px 0 22px rgba(111,39,73,.05) !important;
}
.main-sidebar .brand-link {
    min-height:76px !important; display:flex !important; align-items:center !important;
    padding:17px 20px !important; background:#fff !important;
    border-bottom:1px solid #f2dce7 !important;
}
.main-sidebar .brand-link .brand-image { max-height:38px !important; width:auto !important; margin-right:12px !important; }
.main-sidebar .brand-link .brand-text {
    color:#c92768 !important; font-family:'Playfair Display',Georgia,serif !important;
    font-size:22px !important; font-weight:900 !important; letter-spacing:1px !important; opacity:1 !important;
}
.main-sidebar .nav-header {
    padding:23px 20px 10px !important; color:#c92768 !important;
    font-family:'Nunito Sans','Segoe UI',sans-serif !important; font-size:11px !important;
    font-weight:1000 !important; letter-spacing:1.5px !important; text-transform:uppercase !important;
}
.main-sidebar .nav-sidebar > .nav-item > .nav-link {
    display:flex !important; align-items:center !important; gap:11px !important;
    margin:4px 12px !important; padding:13px 15px !important; min-height:48px !important;
    border:1px solid transparent !important; border-radius:12px !important;
    color:#503342 !important; background:transparent !important;
    font-family:'Nunito Sans','Segoe UI',sans-serif !important; font-size:15px !important;
    font-weight:900 !important; line-height:1.4 !important;
    transition:background .2s ease,color .2s ease,transform .2s ease !important;
}
.main-sidebar .nav-sidebar > .nav-item > .nav-link p {
    color:inherit !important; font-size:15px !important; font-weight:900 !important; margin:0 !important;
}
.main-sidebar .nav-sidebar > .nav-item > .nav-link > i,
.main-sidebar .nav-sidebar > .nav-item > .nav-link > .nav-icon {
    width:22px !important; min-width:22px !important; margin:0 !important;
    color:#bf6289 !important; font-size:17px !important; text-align:center !important; opacity:1 !important;
}
.main-sidebar .nav-sidebar > .nav-item > .nav-link:hover {
    color:#c92768 !important; background:#ffe7f1 !important;
    border-color:#f8d2e2 !important; transform:translateX(2px);
}
.main-sidebar .nav-sidebar > .nav-item > .nav-link:hover > i,
.main-sidebar .nav-sidebar > .nav-item > .nav-link:hover > .nav-icon { color:#d63378 !important; }
.main-sidebar .nav-sidebar > .nav-item > .nav-link.active {
    color:#fff !important; background:linear-gradient(110deg,#ed4a91,#c92768) !important;
    border-color:#d63378 !important; box-shadow:0 6px 15px rgba(214,51,120,.22) !important;
}
.main-sidebar .nav-sidebar > .nav-item > .nav-link.active p,
.main-sidebar .nav-sidebar > .nav-item > .nav-link.active > i,
.main-sidebar .nav-sidebar > .nav-item > .nav-link.active > .nav-icon { color:#fff !important; }
.main-sidebar .nav-treeview > .nav-item > .nav-link {
    margin:3px 12px 3px 23px !important; padding:11px 13px !important;
    border-radius:10px !important; color:#654657 !important; font-size:14px !important; font-weight:800 !important;
}
.main-sidebar .nav-treeview > .nav-item > .nav-link p { font-weight:800 !important; }
.main-sidebar .nav-treeview > .nav-item > .nav-link.active { color:#c92768 !important; background:#ffe7f1 !important; }
.main-sidebar .nav-sidebar { padding-top:8px !important; padding-bottom:22px !important; }
.main-header.navbar { background:#fff !important; border-bottom:1px solid #f3e7ed !important; }

/* HARD OVERRIDES: FORCE THE SIDEBAR TO USE THE LUXSKIN DESIGN */
body .main-sidebar .brand-link,
body .main-sidebar .brand-link .brand-text {
    background-color:#ffffff !important;
}
body .main-sidebar .nav-header {
    color:#c92768 !important;
    opacity:1 !important;
    font-weight:1000 !important;
}
body .main-sidebar .nav-sidebar .nav-item > .nav-link,
body .main-sidebar .nav-sidebar .nav-item > .nav-link p {
    color:#503342 !important;
    font-family:'Nunito Sans','Segoe UI',sans-serif !important;
    font-size:15px !important;
    font-weight:900 !important;
    opacity:1 !important;
    text-shadow:none !important;
}
body .main-sidebar .nav-sidebar .nav-item > .nav-link .nav-icon,
body .main-sidebar .nav-sidebar .nav-item > .nav-link > i {
    color:#bf6289 !important;
    opacity:1 !important;
}
body .main-sidebar .nav-sidebar .nav-item > .nav-link:hover,
body .main-sidebar .nav-sidebar .nav-item > .nav-link:hover p {
    color:#c92768 !important;
    background:#ffe7f1 !important;
}
body .main-sidebar .nav-sidebar .nav-item > .nav-link.active,
body .main-sidebar .nav-sidebar .nav-item > .nav-link.active p,
body .main-sidebar .nav-sidebar .nav-item > .nav-link.active .nav-icon {
    color:#ffffff !important;
    background:linear-gradient(110deg,#ed4a91,#c92768) !important;
}
body .main-sidebar .nav-sidebar .nav-item > .nav-link {
    border-radius:12px !important;
    margin:4px 12px !important;
    padding:13px 15px !important;
}
body .main-sidebar .nav-sidebar .nav-item > .nav-link.active {
    box-shadow:0 6px 15px rgba(214,51,120,.22) !important;
}
body .main-sidebar .brand-link .brand-text {
    color:#c92768 !important;
    font-family:'Playfair Display',Georgia,serif !important;
    font-weight:900 !important;
}

/* HEADER & CLOCK */
.lux-topbar { display:flex; justify-content:space-between; align-items:center; gap:22px; margin:3px 0 27px; }
.lux-eyebrow,.lux-clock-label,.lux-section-kicker,.lux-panel-kicker {
    font-size:10px; font-weight:1000; letter-spacing:1.7px;
}
.lux-eyebrow { color:var(--pink); margin-bottom:8px; }
.lux-heading h1 {
    margin:0; color:var(--ink);
    font-family:'Playfair Display',Georgia,serif !important;
    font-size:43px; font-weight:900; letter-spacing:-.7px;
}
.lux-heading p { color:#806b78; font-size:14px; font-weight:800; margin:10px 0 0; }

.lux-date-card {
    display:flex; align-items:center; gap:17px;
    flex:0 0 260px; min-height:124px; padding:17px 20px;
    border:1px solid #f4c9dc; border-radius:21px;
    background:#fff; box-shadow:0 12px 30px rgba(85,38,61,.06);
}
.lux-date-symbol {
    display:grid; place-items:center; width:65px; height:65px;
    flex:0 0 65px; border-radius:18px;
    background:linear-gradient(145deg,#f75da4,#d91e72); color:#fff;
}
.lux-date-symbol span {
    font-family:'Playfair Display',Georgia,serif !important;
    font-size:38px; font-weight:900; font-style:italic;
}
.lux-date-info { min-width:0; }
.lux-date-label { color:#9b7187; font-size:11px; font-weight:1000; letter-spacing:1px; margin-bottom:5px; }
.lux-date-value { color:#35202d; font-size:20px; font-weight:1000; line-height:1.4; white-space:nowrap; }
.lux-clock { color:#d92775; font-size:14px; font-weight:1000; line-height:1.6; margin-top:3px; font-variant-numeric:tabular-nums; }

/* HERO */
.lux-hero {
    position:relative; overflow:hidden; display:flex; align-items:center; justify-content:space-between;
    min-height:225px; padding:32px 40px; margin-bottom:30px; border-radius:22px;
    background:radial-gradient(circle at 76% 22%,#ffffff30,transparent 23%),
    linear-gradient(115deg,#d92d76,#ed5b99 52%,#f49bbd);
    box-shadow:0 15px 35px #ce30721c;
}
.lux-hero-content { position:relative; z-index:2; max-width:590px; }
.lux-hero-label {
    display:inline-block; padding:7px 11px; border:1px solid #ffffff70;
    border-radius:6px; background:#ffffff21; color:#fff;
    font-size:10px; font-weight:1000; letter-spacing:1.8px;
}
.lux-hero h2 {
    color:#fff; font-family:'Playfair Display',Georgia,serif !important;
    font-size:36px; font-weight:900; letter-spacing:-.4px; margin:16px 0 10px;
}
.lux-hero p { color:#fff; max-width:520px; font-size:14px; font-weight:800; line-height:1.8; margin-bottom:20px; }
.lux-primary-btn {
    display:inline-flex; align-items:center; gap:19px; padding:12px 18px;
    border-radius:9px; background:#fff; color:#c92768 !important;
    font-size:12px; font-weight:1000; text-decoration:none !important;
}
.lux-primary-btn:hover { transform:translateY(-2px); color:#a91f5a !important; }
.lux-hero-decoration { position:relative; width:210px; height:180px; flex:0 0 210px; margin-right:15px; }
.lux-orbit { position:absolute; border:1px solid #ffffff70; border-radius:50%; left:50%; top:45%; transform:translate(-50%,-50%); }
.lux-orbit-one { width:170px; height:170px; }
.lux-orbit-two { width:125px; height:125px; border-style:dashed; }
.lux-decoration-center {
    position:absolute; left:50%; top:45%; transform:translate(-50%,-50%);
    display:grid; place-items:center; width:82px; height:82px; border-radius:50%;
    background:#fff; color:#d43178; font-family:'Playfair Display',Georgia,serif !important;
    font-size:47px; font-weight:900; font-style:italic;
}
.lux-decoration-caption {
    position:absolute; bottom:-2px; left:50%; transform:translateX(-50%);
    color:#fff; text-align:center; font-size:9px; font-weight:1000; letter-spacing:2px; line-height:1.7;
}

/* SECTION & STATS */
.lux-section-heading { display:flex; align-items:flex-end; justify-content:space-between; gap:15px; margin-bottom:17px; }
.lux-section-kicker,.lux-panel-kicker { display:block; color:#cf5b8c; margin-bottom:6px; }
.lux-section-heading h3,.lux-panel-header h3 {
    color:var(--ink); font-family:'Playfair Display',Georgia,serif !important;
    font-size:24px; font-weight:900; margin:0;
}
.lux-live-label { display:inline-flex; align-items:center; gap:7px; padding:8px 11px; border:1px solid #f0e1e8; border-radius:8px; color:#866779; background:#fff; font-size:10px; font-weight:1000; }
.lux-live-dot { width:7px; height:7px; border-radius:50%; background:#df4b8a; }
.lux-stats-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:17px; margin-bottom:30px; }
.lux-stat-card { min-width:0; padding:21px; border:1px solid #f0e4e9; border-radius:16px; background:#fff; box-shadow:0 5px 19px #481f3408; transition:.2s; }
.lux-stat-card:hover { transform:translateY(-3px); box-shadow:0 12px 26px #481f3414; }
.lux-stat-top { display:flex; align-items:center; justify-content:space-between; gap:8px; }
.lux-stat-label { color:#76616e; font-size:13px; font-weight:1000; }
.lux-stat-icon { display:grid; place-items:center; width:42px; height:42px; border-radius:12px; font-size:16px; }
.stat-pink .lux-stat-icon { color:#d82e78; background:#fff0f6; }
.stat-green .lux-stat-icon { color:#27864d; background:#e9f8ef; }
.stat-gold .lux-stat-icon { color:#b58335; background:#fff7e8; }
.lux-stat-number { color:var(--ink); font-size:39px; font-weight:1000; letter-spacing:-1px; margin:14px 0 4px; overflow-wrap:anywhere; font-variant-numeric:tabular-nums; }
.lux-stat-description { color:#9b8993; font-size:12px; font-weight:900; }
.lux-stat-line { width:40px; height:3px; border-radius:3px; margin-top:17px; }
.stat-pink .lux-stat-line { background:#e83e80; }
.stat-green .lux-stat-line { background:#43a66b; }
.stat-gold .lux-stat-line { background:#d5a34d; }

/* PRODUCT PANEL */
.lux-panel { min-width:0; overflow:hidden; border:1px solid #f0e4e9; border-radius:17px; background:#fff; box-shadow:0 5px 19px #481f3408; }
.lux-panel-header { display:flex; align-items:center; justify-content:space-between; gap:15px; padding:23px; }
.lux-panel-header p { color:#9b8993; font-size:12px; font-weight:800; margin:8px 0 0; }
.lux-panel-header h3 { font-size:22px; }
.lux-count-label { padding:8px 11px; border-radius:8px; background:#fff0f6; color:#c92768; font-size:10px; font-weight:1000; white-space:nowrap; }


/* ACTIONS & SUCCESS MESSAGE */
.lux-panel-actions { display:flex; align-items:center; justify-content:flex-end; gap:12px; flex-wrap:wrap; }
.lux-add-button {
    display:inline-flex; align-items:center; justify-content:center; gap:9px;
    flex-shrink:0; padding:12px 16px; border:1px solid #d63378; border-radius:9px;
    background:linear-gradient(110deg,#ed4a91,#ca2c70); color:#fff !important;
    font-family:'Nunito Sans',sans-serif !important; font-size:11px; font-weight:1000;
    text-decoration:none !important; box-shadow:0 7px 17px #d6337828; transition:transform .2s,box-shadow .2s;
}
.lux-add-button:hover { color:#fff !important; transform:translateY(-2px); box-shadow:0 10px 20px #d6337835; }
.lux-success-message { margin:18px 23px 0; padding:14px 16px; border:1px solid #c9ead4; border-radius:10px; background:#effaf3; color:#267447; font-size:13px; font-weight:900; }
.lux-success-message i { margin-right:8px; }

/* SEARCH */
.lux-toolbar { display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:17px; padding:19px 23px; border-top:1px solid #f5eaf0; border-bottom:1px solid #f0e5eb; background:#fffafd; }
.lux-search-form { flex:1; min-width:250px; }
.lux-search-label { display:block; margin-bottom:8px; color:#9a7186; font-size:10px; font-weight:1000; letter-spacing:1.3px; }
.lux-search-control { display:flex; align-items:center; gap:10px; min-height:46px; padding:5px 6px 5px 13px; border:1px solid #ead8e2; border-radius:10px; background:#fff; }
.lux-search-control > i { color:#c47a9c; font-size:14px; }
.lux-search-control input { flex:1; min-width:0; border:0; outline:0; color:#382532; background:transparent; font-family:'Nunito Sans',sans-serif; font-size:13px; font-weight:800; }
.lux-search-control input::placeholder { color:#b4a2ad; font-weight:700; }
.lux-search-button { border:0; border-radius:7px; padding:10px 15px; background:#d93479; color:#fff; font-size:11px; font-weight:1000; }
.lux-search-button:hover { background:#bd2566; }
.lux-clear-search { color:#c92768 !important; font-size:10px; font-weight:1000; text-decoration:none !important; }
.lux-toolbar-note { color:#9b8993; font-size:11px; font-weight:900; }

/* TABLE */
.lux-table { width:100%; margin-bottom:0; }
.lux-table thead th { padding:14px 15px; border-top:0; border-bottom:1px solid #f0e5eb; background:#fff7fb; color:#98798a; font-size:10px; font-weight:1000; letter-spacing:.8px; white-space:nowrap; }
.lux-table tbody td { padding:16px 15px; border-top:1px solid #f5edf1; color:#4c3945; font-size:12px; font-weight:800; line-height:1.7; vertical-align:middle; }
.lux-table tbody tr:hover { background:#fffafd; }
.lux-product-cell { display:flex; align-items:center; gap:11px; min-width:190px; }
.lux-product-monogram { display:grid; place-items:center; width:42px; height:42px; flex:0 0 42px; border-radius:12px; background:linear-gradient(145deg,#fff0f6,#f8d8e7); color:#d63378; font-family:'Playfair Display',Georgia,serif !important; font-size:24px; font-weight:900; font-style:italic; }
.lux-product-info { display:flex; flex-direction:column; gap:4px; min-width:0; }
.lux-product-info strong { color:#382532; font-size:12px; font-weight:1000; overflow-wrap:anywhere; }
.lux-product-info small { color:#a4919c; font-size:10px; font-weight:900; }
.lux-sku { color:#776273; font-size:11px; font-weight:900; white-space:nowrap; }
.lux-category,.lux-brand { color:#796675; font-size:11px; font-weight:900; }
.lux-price { color:#382532; font-size:12px; font-weight:1000; white-space:nowrap; }
.lux-old-price { color:#b4a2ad; font-size:10px; font-weight:800; text-decoration:line-through; }
.lux-status { display:inline-flex; align-items:center; gap:6px; padding:6px 8px; border-radius:6px; font-size:9px; font-weight:1000; white-space:nowrap; }
.status-active { background:#e9f8ef; color:#27864d; }
.status-draft { background:#fff4df; color:#a16d13; }
.status-other { background:#f3edf2; color:#796576; }
.lux-status-dot { width:6px; height:6px; border-radius:50%; background:currentColor; }

/* EMPTY */
.lux-empty-state { padding:42px 15px; text-align:center; }
.lux-empty-icon { display:grid; place-items:center; width:56px; height:56px; margin:0 auto 14px; border-radius:16px; background:#fff0f6; color:#d63378; font-size:21px; }
.lux-empty-state h4 { color:#382532; font-family:'Playfair Display',Georgia,serif !important; font-size:19px; font-weight:900; margin-bottom:7px; }
.lux-empty-state p { color:#9b8993; font-size:12px; font-weight:800; }
.lux-empty-link { color:#d63378 !important; font-size:12px; font-weight:1000; }

/* PAGINATION */
.lux-pagination { display:flex; align-items:center; justify-content:space-between; gap:15px; flex-wrap:wrap; padding:18px 23px; border-top:1px solid #f4eaf0; }
.lux-pagination-info { color:#9b8993; font-size:10px; font-weight:1000; letter-spacing:.7px; }
.lux-pagination-links nav { display:flex; justify-content:flex-end; }
.lux-pagination-links .pagination { margin:0; gap:4px; }
.lux-pagination-links .page-link { border:1px solid #f0dce6; border-radius:7px !important; color:#c92768; font-size:12px; font-weight:900; }
.lux-pagination-links .page-item.active .page-link { border-color:#d93479; background:#d93479; color:#fff; }
.lux-pagination-links .page-item.disabled .page-link { color:#c9b8c2; }

/* BOTTOM */
.lux-bottom-banner { display:flex; align-items:center; gap:20px; margin-top:25px; padding:22px 25px; border:1px solid #f1dfe8; border-radius:16px; background:linear-gradient(100deg,#fff,#fff1f7); }
.lux-bottom-mark { display:grid; place-items:center; width:55px; height:55px; flex:0 0 55px; border-radius:50%; background:linear-gradient(135deg,#ed4a91,#bd2869); color:#fff; font-family:'Playfair Display',Georgia,serif !important; font-size:32px; font-weight:900; font-style:italic; }
.lux-bottom-copy { flex:1; min-width:0; }
.lux-bottom-copy > span { color:#d63378; font-size:10px; font-weight:1000; letter-spacing:1.5px; }
.lux-bottom-copy h3 { color:#382532; font-family:'Playfair Display',Georgia,serif !important; font-size:20px; font-weight:900; margin:6px 0; }
.lux-bottom-copy p { color:#907b88; font-size:12px; font-weight:800; margin:0; line-height:1.8; }
.lux-bottom-link { flex-shrink:0; padding:11px 13px; border:1px solid #eac8d9; border-radius:8px; color:#c92768 !important; font-size:10px; font-weight:1000; text-decoration:none !important; background:#fff; }
.lux-footer { display:flex; justify-content:space-between; gap:12px; padding:21px 2px 0; color:#a28e99; font-size:10px; font-weight:1000; }

/* RESPONSIVE */
@media(max-width:1200px) {
    .lux-stats-grid { grid-template-columns:repeat(3,minmax(0,1fr)); }
}
@media(max-width:900px) {
    .lux-stats-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }
    .lux-hero-decoration { opacity:.7; }
}
@media(max-width:767px) {
    .main-sidebar .nav-sidebar > .nav-item > .nav-link {
        margin:4px 10px !important; padding:13px 14px !important; font-size:15px !important;
    }
    .main-sidebar .nav-sidebar > .nav-item > .nav-link p { font-size:15px !important; }
    .main-sidebar .nav-header { padding-left:18px !important; }
}
@media(max-width:700px) {
    .content { padding:16px 12px 25px !important; }
    .lux-topbar { align-items:stretch; flex-direction:column; gap:17px; }
    .lux-heading h1 { font-size:36px; }
    .lux-date-card { flex-basis:auto; width:100%; max-width:320px; }
    .lux-date-value { font-size:19px; }
    .lux-hero { min-height:auto; padding:26px 22px; border-radius:17px; }
    .lux-hero h2 { font-size:29px; }
    .lux-hero-decoration { display:none; }
    .lux-stats-grid { gap:11px; }
    .lux-stat-card { padding:14px; }
    .lux-stat-number { font-size:32px; }
    .lux-stat-label { font-size:12px; }
    .lux-stat-icon { width:34px; height:34px; font-size:13px; }
    .lux-section-heading h3,.lux-panel-header h3 { font-size:21px; }
    .lux-live-label { font-size:9px; }
    .lux-panel-header { padding:18px 14px; }
    .lux-panel-actions { width:100%; justify-content:space-between; }
    .lux-add-button { flex:1; }
    .lux-success-message { margin:14px 14px 0; }
    .lux-toolbar { padding:15px; }
    .lux-search-form { min-width:100%; }
    .lux-table thead th,.lux-table tbody td { padding:12px 10px; }
    .lux-bottom-banner { align-items:flex-start; flex-wrap:wrap; padding:18px; }
    .lux-bottom-copy { flex-basis:calc(100% - 75px); }
    .lux-bottom-copy h3 { font-size:18px; }
    .lux-bottom-link { margin-left:75px; }
    .lux-pagination { padding:15px; }
}
</style>
@stop

@section('js')
<script>
(function () {
    const clock = document.getElementById('lux-clock');
    const date = document.getElementById('lux-date');
    if (!clock || !date) return;

    const timeFormatter = new Intl.DateTimeFormat('id-ID', {
        timeZone: 'Asia/Jakarta',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    });

    const dateFormatter = new Intl.DateTimeFormat('id-ID', {
        timeZone: 'Asia/Jakarta',
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });

    function updateClock() {
        const now = new Date();
        clock.textContent = timeFormatter.format(now) + ' WIB';
        date.textContent = dateFormatter.format(now);
    }

    updateClock();
    setInterval(updateClock, 1000);
})();
</script>
@stop
