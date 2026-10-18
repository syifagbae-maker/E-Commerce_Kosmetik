
@extends('adminlte::page')

@section('title', 'Dashboard LuxSkin')

@section('content_header')
@stop

@section('content')
<div class="lux-dashboard">

    <div class="lux-topbar">
        <div class="lux-heading">
            <div class="lux-eyebrow">LUXSKIN BEAUTY STUDIO</div>
            <h1>Dashboard</h1>
            <p>Selamat datang kembali di panel admin LuxSkin.</p>
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
            <div class="lux-hero-label">ADMINISTRATION PANEL</div>
            <h2>Beauty in Every Detail.</h2>
            <p>Kelola produk, pantau aktivitas toko, dan berikan pengalaman belanja terbaik bagi setiap pelanggan LuxSkin.</p>
            <a href="{{ url('/admin/produk') }}" class="lux-primary-btn">
                KELOLA PRODUK <span>→</span>
            </a>
        </div>

        <div class="lux-hero-decoration" aria-hidden="true">
            <div class="lux-orbit lux-orbit-one"></div>
            <div class="lux-orbit lux-orbit-two"></div>
            <div class="lux-decoration-center">L</div>
            <div class="lux-decoration-caption">LUXSKIN<br>BEAUTY STUDIO</div>
        </div>
    </section>

    <div class="lux-section-heading">
        <div>
            <span class="lux-section-kicker">RINGKASAN TOKO</span>
            <h3>Overview</h3>
        </div>
        <span class="lux-live-label">
            <span class="lux-live-dot"></span>
            ADMIN DASHBOARD
        </span>
    </div>

    <div class="lux-stats-grid">
        <div class="lux-stat-card stat-pink">
            <div class="lux-stat-top">
                <span class="lux-stat-label">Total Produk</span>
                <div class="lux-stat-icon"><i class="fas fa-box-open"></i></div>
            </div>
            <div class="lux-stat-number">{{ number_format($totalProduk ?? 0, 0, ',', '.') }}</div>
            <div class="lux-stat-description">Produk dalam katalog</div>
            <div class="lux-stat-line"></div>
        </div>

        <div class="lux-stat-card stat-purple">
            <div class="lux-stat-top">
                <span class="lux-stat-label">Total Pesanan</span>
                <div class="lux-stat-icon"><i class="fas fa-shopping-bag"></i></div>
            </div>
            <div class="lux-stat-number">{{ number_format($totalPesanan ?? 0, 0, ',', '.') }}</div>
            <div class="lux-stat-description">Pesanan tercatat</div>
            <div class="lux-stat-line"></div>
        </div>

        <div class="lux-stat-card stat-rose">
            <div class="lux-stat-top">
                <span class="lux-stat-label">Pelanggan</span>
                <div class="lux-stat-icon"><i class="fas fa-users"></i></div>
            </div>
            <div class="lux-stat-number">{{ number_format($totalPelanggan ?? 0, 0, ',', '.') }}</div>
            <div class="lux-stat-description">Akun pelanggan terdaftar</div>
            <div class="lux-stat-line"></div>
        </div>

        <div class="lux-stat-card stat-gold">
            <div class="lux-stat-top">
                <span class="lux-stat-label">Kategori</span>
                <div class="lux-stat-icon"><i class="fas fa-layer-group"></i></div>
            </div>
            <div class="lux-stat-number">{{ number_format($totalKategori ?? 0, 0, ',', '.') }}</div>
            <div class="lux-stat-description">Kategori produk</div>
            <div class="lux-stat-line"></div>
        </div>
    </div>

    <div class="lux-main-grid">
        <section class="lux-panel">
            <div class="lux-panel-header">
                <div>
                    <span class="lux-panel-kicker">KATALOG TOKO</span>
                    <h3>Produk Terbaru</h3>
                    <p>Produk yang terakhir ditambahkan ke katalog.</p>
                </div>
                <a href="{{ url('/admin/produk') }}" class="lux-text-link">LIHAT SEMUA →</a>
            </div>

            <div class="table-responsive">
                <table class="table lux-table">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($produkTerbaru ?? collect()) as $item)
                            <tr>
                                <td>
                                    <div class="lux-product-name">{{ $item->nama_produk }}</div>
                                    <div class="lux-product-meta">ID PRODUK: {{ $item->id_produk }}</div>
                                </td>
                                <td class="lux-price">
                                    Rp{{ number_format($item->harga ?? 0, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if(strtolower($item->status ?? '') === 'aktif')
                                        <span class="lux-status status-active">AKTIF</span>
                                    @elseif(strtolower($item->status ?? '') === 'draft')
                                        <span class="lux-status status-draft">DRAFT</span>
                                    @else
                                        <span class="lux-status status-other">
                                            {{ strtoupper($item->status ?? 'BELUM DIATUR') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="lux-empty-state">
                                        <div class="lux-empty-icon"><i class="fas fa-box-open"></i></div>
                                        <h4>Belum Ada Produk</h4>
                                        <p>Produk yang ditambahkan akan ditampilkan di sini.</p>
                                        <a href="{{ url('/admin/produk') }}" class="lux-empty-link">
                                            BUKA KATALOG PRODUK →
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="lux-panel lux-menu-panel">
            <div class="lux-panel-header">
                <div>
                    <span class="lux-panel-kicker">NAVIGASI ADMIN</span>
                    <h3>Menu Utama</h3>
                    <p>Akses pengelolaan toko LuxSkin.</p>
                </div>
            </div>

            <a href="{{ url('/admin') }}" class="lux-menu-item lux-menu-current">
                <span class="lux-menu-icon"><i class="fas fa-th-large"></i></span>
                <span class="lux-menu-text"><strong>DASHBOARD</strong><small>Ringkasan toko</small></span>
                <span class="lux-menu-arrow">→</span>
            </a>

            <a href="{{ url('/admin/produk') }}" class="lux-menu-item">
                <span class="lux-menu-icon"><i class="fas fa-box-open"></i></span>
                <span class="lux-menu-text"><strong>KELOLA PRODUK</strong><small>Katalog dan harga</small></span>
                <span class="lux-menu-arrow">→</span>
            </a>

            <a href="{{ url('/admin/kategori') }}" class="lux-menu-item">
                <span class="lux-menu-icon"><i class="fas fa-layer-group"></i></span>
                <span class="lux-menu-text"><strong>KATEGORI</strong><small>Pengelompokan produk</small></span>
                <span class="lux-menu-arrow">→</span>
            </a>

            <a href="{{ url('/admin/brand') }}" class="lux-menu-item">
                <span class="lux-menu-icon"><i class="fas fa-tags"></i></span>
                <span class="lux-menu-text"><strong>BRAND</strong><small>Daftar merek</small></span>
                <span class="lux-menu-arrow">→</span>
            </a>

            <a href="{{ url('/admin/pesanan') }}" class="lux-menu-item">
                <span class="lux-menu-icon"><i class="fas fa-receipt"></i></span>
                <span class="lux-menu-text"><strong>PESANAN</strong><small>Informasi transaksi</small></span>
                <span class="lux-menu-arrow">→</span>
            </a>
        </aside>
    </div>

    <section class="lux-bottom-banner">
        <div class="lux-bottom-mark">L</div>
        <div class="lux-bottom-copy">
            <span>LUXSKIN BEAUTY STUDIO</span>
            <h3>Every Skin Deserves a Little Luxury.</h3>
            <p>Kelola toko dengan teliti dan berikan pengalaman terbaik untuk pelanggan.</p>
        </div>
        <a href="{{ url('/admin/produk') }}" class="lux-bottom-link">BUKA KATALOG →</a>
    </section>

    <div class="lux-footer">
        <span>© {{ date('Y') }} LUXSKIN BEAUTY STUDIO</span>
        <span>ADMIN DASHBOARD</span>
    </div>
</div>
@stop

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@600;700;800;900;1000&family=Playfair+Display:wght@700;800;900&display=swap');

:root {
    --pink: #e83e80;
    --pink-dark: #c92768;
    --ink: #30212b;
    --muted: #8f7e89;
    --border: #f1e5eb;
}

.content-wrapper { background: #fff8fb !important; }
.content { padding: 24px 25px 35px !important; }

.lux-dashboard, .lux-dashboard * { box-sizing: border-box; }
.lux-dashboard {
    color: var(--ink);
    font-family: 'Nunito Sans', 'Segoe UI', sans-serif !important;
    font-weight: 800;
    -webkit-font-smoothing: antialiased;
}
.lux-dashboard p, .lux-dashboard a, .lux-dashboard td,
.lux-dashboard th, .lux-dashboard small, .lux-dashboard span {
    font-family: 'Nunito Sans', 'Segoe UI', sans-serif;
}

/* SIDEBAR */
.main-sidebar { background: linear-gradient(180deg,#351a2b,#241421) !important; }
.brand-link { padding: 22px 16px !important; border-bottom: 1px solid #ffffff18 !important; }
.brand-link .brand-text {
    color: #fff !important;
    font-family: 'Playfair Display', Georgia, serif !important;
    font-size: 23px !important;
    font-weight: 900 !important;
    letter-spacing: 1px;
}
.main-sidebar .nav-sidebar .nav-link {
    margin: 4px 11px !important;
    padding: 13px 14px !important;
    border-radius: 11px !important;
    color: #f8eaf1 !important;
    font-size: 15px !important;
    font-weight: 900 !important;
}
.main-sidebar .nav-sidebar .nav-link p {
    font-size: 15px !important;
    font-weight: 900 !important;
}
.main-sidebar .nav-sidebar .nav-link i { font-size: 16px !important; margin-right: 7px; }
.main-sidebar .nav-sidebar .nav-link:hover,
.main-sidebar .nav-sidebar .nav-link.active {
    color: #fff !important;
    background: linear-gradient(110deg,#ed4a91,#ca2c70) !important;
}
.main-header.navbar { background: #fff !important; border-bottom: 1px solid #f3e7ed !important; }

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
    background:linear-gradient(145deg,#f75da4,#d91e72);
    color:white;
}
.lux-date-symbol span {
    font-family:'Playfair Display',Georgia,serif !important;
    font-size:38px; font-weight:900; font-style:italic;
}
.lux-date-info { min-width:0; }
.lux-date-label { color:#9b7187; font-size:11px; font-weight:1000; letter-spacing:1px; margin-bottom:5px; }
.lux-date-value {
    color:#35202d; font-size:20px; font-weight:1000;
    line-height:1.4; white-space:nowrap;
}
.lux-clock {
    color:#d92775; font-size:14px; font-weight:1000;
    line-height:1.6; margin-top:3px; font-variant-numeric:tabular-nums;
}

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

/* SECTION */
.lux-section-heading { display:flex; align-items:flex-end; justify-content:space-between; gap:15px; margin-bottom:17px; }
.lux-section-kicker,.lux-panel-kicker { display:block; color:#cf5b8c; margin-bottom:6px; }
.lux-section-heading h3,.lux-panel-header h3 {
    color:var(--ink); font-family:'Playfair Display',Georgia,serif !important;
    font-size:24px; font-weight:900; margin:0;
}
.lux-live-label { display:inline-flex; align-items:center; gap:7px; padding:8px 11px; border:1px solid #f0e1e8; border-radius:8px; color:#866779; background:#fff; font-size:10px; font-weight:1000; }
.lux-live-dot { width:7px; height:7px; border-radius:50%; background:#df4b8a; }

/* STATS */
.lux-stats-grid { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:17px; margin-bottom:30px; }
.lux-stat-card { min-width:0; padding:20px; border:1px solid #f0e4e9; border-radius:16px; background:#fff; box-shadow:0 5px 19px #481f3408; transition:.2s; }
.lux-stat-card:hover { transform:translateY(-3px); box-shadow:0 12px 26px #481f3414; }
.lux-stat-top { display:flex; align-items:center; justify-content:space-between; gap:8px; }
.lux-stat-label { color:#76616e; font-size:13px; font-weight:1000; }
.lux-stat-icon { display:grid; place-items:center; width:42px; height:42px; border-radius:12px; font-size:16px; }
.stat-pink .lux-stat-icon { color:#d82e78; background:#fff0f6; }
.stat-purple .lux-stat-icon { color:#8557bf; background:#f5efff; }
.stat-rose .lux-stat-icon { color:#d95670; background:#fff0f1; }
.stat-gold .lux-stat-icon { color:#b58335; background:#fff7e8; }
.lux-stat-number { color:var(--ink); font-size:39px; font-weight:1000; letter-spacing:-1px; margin:14px 0 4px; overflow-wrap:anywhere; font-variant-numeric:tabular-nums; }
.lux-stat-description { color:#9b8993; font-size:12px; font-weight:900; }
.lux-stat-line { width:40px; height:3px; border-radius:3px; margin-top:17px; }
.stat-pink .lux-stat-line { background:#e83e80; }
.stat-purple .lux-stat-line { background:#9a75d4; }
.stat-rose .lux-stat-line { background:#e46c80; }
.stat-gold .lux-stat-line { background:#d5a34d; }

/* PANELS AND TABLE */
.lux-main-grid { display:grid; grid-template-columns:minmax(0,1.65fr) minmax(280px,.9fr); gap:21px; align-items:start; }
.lux-panel { min-width:0; overflow:hidden; border:1px solid #f0e4e9; border-radius:17px; background:#fff; box-shadow:0 5px 19px #481f3408; }
.lux-panel-header { display:flex; align-items:center; justify-content:space-between; gap:15px; padding:23px 23px 19px; }
.lux-panel-header p { color:#9b8993; font-size:12px; font-weight:800; margin:8px 0 0; }
.lux-panel-header h3 { font-size:21px; }
.lux-text-link { flex-shrink:0; color:#d63378 !important; font-size:11px; font-weight:1000; text-decoration:none !important; }
.lux-table { width:100%; margin-bottom:0; }
.lux-table thead th { padding:13px 18px; border-top:1px solid #f4eaf0; border-bottom:1px solid #f0e5eb; background:#fff9fc; color:#9a7e8d; font-size:10px; font-weight:1000; letter-spacing:1px; white-space:nowrap; }
.lux-table tbody td { padding:16px 18px; border-top:1px solid #f5edf1; color:#4c3945; font-size:13px; font-weight:800; line-height:1.7; vertical-align:middle; }
.lux-product-name { color:#382532; font-size:13px; font-weight:1000; max-width:240px; overflow-wrap:anywhere; }
.lux-product-meta { color:#a4919c; font-size:11px; font-weight:900; margin-top:5px; }
.lux-price { font-weight:1000 !important; white-space:nowrap; }
.lux-status { display:inline-block; padding:6px 9px; border-radius:6px; font-size:10px; font-weight:1000; white-space:nowrap; }
.status-active { background:#e9f8ef; color:#27864d; }
.status-draft { background:#fff4df; color:#a16d13; }
.status-other { background:#f3edf2; color:#796576; }

/* EMPTY */
.lux-empty-state { padding:35px 15px 40px; text-align:center; }
.lux-empty-icon { display:grid; place-items:center; width:54px; height:54px; margin:0 auto 14px; border-radius:16px; background:#fff0f6; color:#d63378; font-size:20px; }
.lux-empty-state h4 { color:#382532; font-family:'Playfair Display',Georgia,serif !important; font-size:18px; font-weight:900; margin-bottom:7px; }
.lux-empty-state p { color:#9b8993; font-size:12px; font-weight:800; }
.lux-empty-link { color:#d63378 !important; font-size:12px; font-weight:1000; }

/* QUICK MENU */
.lux-menu-panel .lux-panel-header { padding-bottom:20px; }
.lux-menu-item { display:flex; align-items:center; gap:12px; margin:0 13px 8px; padding:12px; border:1px solid transparent; border-radius:11px; text-decoration:none !important; transition:.2s; }
.lux-menu-item:hover { background:#fff7fa; border-color:#f5dce7; transform:translateX(2px); }
.lux-menu-current { background:#fff0f6; border-color:#f7d6e5; }
.lux-menu-icon { display:grid; place-items:center; width:40px; height:40px; flex:0 0 40px; border-radius:11px; background:#f8eaf1; color:#d63378; font-size:15px; }
.lux-menu-current .lux-menu-icon { background:#e83e80; color:#fff; }
.lux-menu-text { display:flex; flex:1; flex-direction:column; min-width:0; gap:4px; }
.lux-menu-text strong { color:#402b38; font-size:12px; font-weight:1000; }
.lux-menu-text small { color:#a08c98; font-size:11px; font-weight:900; }
.lux-menu-arrow { color:#c5a2b4; font-size:18px; font-weight:1000; }

/* BOTTOM */
.lux-bottom-banner { display:flex; align-items:center; gap:20px; margin-top:25px; padding:22px 25px; border:1px solid #f1dfe8; border-radius:16px; background:linear-gradient(100deg,#fff,#fff1f7); }
.lux-bottom-mark { display:grid; place-items:center; width:55px; height:55px; flex:0 0 55px; border-radius:50%; background:linear-gradient(135deg,#ed4a91,#bd2869); color:#fff; font-family:'Playfair Display',Georgia,serif !important; font-size:32px; font-weight:900; font-style:italic; }
.lux-bottom-copy { flex:1; min-width:0; }
.lux-bottom-copy > span { color:#d63378; font-size:10px; font-weight:1000; letter-spacing:1.5px; }
.lux-bottom-copy h3 { color:#382532; font-family:'Playfair Display',Georgia,serif !important; font-size:20px; font-weight:900; margin:6px 0; }
.lux-bottom-copy p { color:#907b88; font-size:12px; font-weight:800; margin:0; line-height:1.8; }
.lux-bottom-link { flex-shrink:0; padding:11px 13px; border:1px solid #eac8d9; border-radius:8px; color:#c92768 !important; font-size:11px; font-weight:1000; text-decoration:none !important; background:#fff; }
.lux-footer { display:flex; justify-content:space-between; gap:12px; padding:21px 2px 0; color:#a28e99; font-size:10px; font-weight:1000; }

/* RESPONSIVE */
@media(max-width:1100px) {
    .lux-stats-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }
    .lux-main-grid { grid-template-columns:1fr; }
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
    .lux-table thead th,.lux-table tbody td { padding:12px 10px; }
    .lux-bottom-banner { align-items:flex-start; flex-wrap:wrap; padding:18px; }
    .lux-bottom-copy { flex-basis:calc(100% - 75px); }
    .lux-bottom-copy h3 { font-size:18px; }
    .lux-bottom-link { margin-left:75px; }
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
