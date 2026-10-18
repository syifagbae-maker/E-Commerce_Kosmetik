@extends('adminlte::page')

@section('title', 'Tambah Produk LuxSkin')

@section('content_header')
@stop

@section('content')
<div class="lux-create">

    <div class="lux-topbar">
        <div class="lux-heading">
            <div class="lux-eyebrow">LUXSKIN BEAUTY STUDIO</div>
            <h1>Tambah Produk</h1>
            <p>Lengkapi informasi produk baru untuk katalog LuxSkin.</p>
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

    <section class="lux-form-hero">
        <span class="lux-form-eyebrow">PRODUCT MANAGEMENT</span>
        <h2>Give Your Collection a New Glow.</h2>
        <p>Masukkan data dengan benar agar informasi produk tersimpan rapi dan mudah dikelola.</p>
    </section>

    @if($errors->any())
        <div class="lux-alert lux-alert-error">
            <strong>Periksa kembali data produk.</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.produk.store') }}" method="POST">
        @csrf

        <section class="lux-form-panel">
            <div class="lux-form-heading">
                <div class="lux-form-heading-icon"><i class="fas fa-box-open"></i></div>
                <div>
                    <h3>Informasi Utama</h3>
                    <p>Nama, SKU, kategori, dan brand produk.</p>
                </div>
            </div>

            <div class="lux-form-grid">
                <div class="lux-field lux-field-full">
                    <label for="nama_produk">Nama Produk <span>*</span></label>
                    <input
                        type="text"
                        id="nama_produk"
                        name="nama_produk"
                        value="{{ old('nama_produk') }}"
                        placeholder="Contoh: LuxSkin Brightening Serum"
                        maxlength="150"
                        required
                    >
                    @error('nama_produk') <small class="lux-error">{{ $message }}</small> @enderror
                </div>

                <div class="lux-field">
                    <label for="sku">SKU Produk <span>*</span></label>
                    <input
                        type="text"
                        id="sku"
                        name="sku"
                        value="{{ old('sku') }}"
                        placeholder="Contoh: LUX-SER-001"
                        maxlength="100"
                        required
                    >
                    <small class="lux-hint">Kode produk harus unik.</small>
                    @error('sku') <small class="lux-error">{{ $message }}</small> @enderror
                </div>

                <div class="lux-field">
                    <label for="status">Status Produk <span>*</span></label>
                    <select id="status" name="status" required>
                        <option value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>
                    </select>
                    @error('status') <small class="lux-error">{{ $message }}</small> @enderror
                </div>

                <div class="lux-field">
                    <label for="id_kategori">Kategori</label>
                    <select id="id_kategori" name="id_kategori">
                        <option value="">Pilih kategori (opsional)</option>
                        @forelse($kategori as $item)
                            <option value="{{ $item->id_kategori }}"
                                {{ (string) old('id_kategori') === (string) $item->id_kategori ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @empty
                            <option value="" disabled>Belum ada kategori</option>
                        @endforelse
                    </select>
                    @error('id_kategori') <small class="lux-error">{{ $message }}</small> @enderror
                </div>

                <div class="lux-field">
                    <label for="id_brand">Brand</label>
                    <select id="id_brand" name="id_brand">
                        <option value="">Pilih brand (opsional)</option>
                        @forelse($brand as $item)
                            <option value="{{ $item->id_brand }}"
                                {{ (string) old('id_brand') === (string) $item->id_brand ? 'selected' : '' }}>
                                {{ $item->nama_brand }}
                            </option>
                        @empty
                            <option value="" disabled>Belum ada brand</option>
                        @endforelse
                    </select>
                    @error('id_brand') <small class="lux-error">{{ $message }}</small> @enderror
                </div>
            </div>
        </section>

        <section class="lux-form-panel">
            <div class="lux-form-heading">
                <div class="lux-form-heading-icon"><i class="fas fa-wallet"></i></div>
                <div>
                    <h3>Harga dan Berat</h3>
                    <p>Informasi harga jual, harga coret, dan berat produk.</p>
                </div>
            </div>

            <div class="lux-form-grid">
                <div class="lux-field">
                    <label for="harga">Harga Jual (Rp) <span>*</span></label>
                    <div class="lux-input-prefix">
                        <span>Rp</span>
                        <input
                            type="number"
                            id="harga"
                            name="harga"
                            value="{{ old('harga') }}"
                            min="0"
                            step="0.01"
                            placeholder="75000"
                            required
                        >
                    </div>
                    @error('harga') <small class="lux-error">{{ $message }}</small> @enderror
                </div>

                <div class="lux-field">
                    <label for="harga_coret">Harga Coret (Rp)</label>
                    <div class="lux-input-prefix">
                        <span>Rp</span>
                        <input
                            type="number"
                            id="harga_coret"
                            name="harga_coret"
                            value="{{ old('harga_coret') }}"
                            min="0"
                            step="0.01"
                            placeholder="95000"
                        >
                    </div>
                    <small class="lux-hint">Opsional, isi jika ada harga promo.</small>
                    @error('harga_coret') <small class="lux-error">{{ $message }}</small> @enderror
                </div>

                <div class="lux-field">
                    <label for="berat_gram">Berat Produk (gram)</label>
                    <input
                        type="number"
                        id="berat_gram"
                        name="berat_gram"
                        value="{{ old('berat_gram') }}"
                        min="0"
                        step="0.01"
                        placeholder="30"
                    >
                    @error('berat_gram') <small class="lux-error">{{ $message }}</small> @enderror
                </div>
            </div>
        </section>

        <section class="lux-form-panel">
            <div class="lux-form-heading">
                <div class="lux-form-heading-icon"><i class="fas fa-feather-alt"></i></div>
                <div>
                    <h3>Detail Produk</h3>
                    <p>Informasi yang membantu pelanggan memahami produk.</p>
                </div>
            </div>

            <div class="lux-form-grid">
                <div class="lux-field lux-field-full">
                    <label for="deskripsi">Deskripsi Produk</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                        placeholder="Jelaskan produk, keunggulan, dan informasi penting lainnya...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <small class="lux-error">{{ $message }}</small> @enderror
                </div>

                <div class="lux-field lux-field-full">
                    <label for="manfaat">Manfaat Produk</label>
                    <textarea id="manfaat" name="manfaat" rows="3"
                        placeholder="Tuliskan manfaat produk...">{{ old('manfaat') }}</textarea>
                    @error('manfaat') <small class="lux-error">{{ $message }}</small> @enderror
                </div>

                <div class="lux-field lux-field-full">
                    <label for="cara_pakai">Cara Pakai</label>
                    <textarea id="cara_pakai" name="cara_pakai" rows="3"
                        placeholder="Tuliskan petunjuk penggunaan...">{{ old('cara_pakai') }}</textarea>
                    @error('cara_pakai') <small class="lux-error">{{ $message }}</small> @enderror
                </div>

                <div class="lux-field lux-field-full">
                    <label for="komposisi">Komposisi</label>
                    <textarea id="komposisi" name="komposisi" rows="3"
                        placeholder="Tuliskan komposisi produk...">{{ old('komposisi') }}</textarea>
                    @error('komposisi') <small class="lux-error">{{ $message }}</small> @enderror
                </div>

                <div class="lux-field lux-field-full">
                    <label for="jenis_kulit">Jenis Kulit</label>
                    <input
                        type="text"
                        id="jenis_kulit"
                        name="jenis_kulit"
                        value="{{ old('jenis_kulit') }}"
                        placeholder="Contoh: Semua jenis kulit"
                        maxlength="255"
                    >
                    @error('jenis_kulit') <small class="lux-error">{{ $message }}</small> @enderror
                </div>
            </div>
        </section>

        <div class="lux-form-actions">
            <a href="{{ route('admin.produk.index') }}" class="lux-cancel-btn">
                BATAL
            </a>
            <button type="submit" class="lux-save-btn">
                <i class="fas fa-check"></i> SIMPAN PRODUK
            </button>
        </div>
    </form>

    <div class="lux-footer">
        <span>© {{ date('Y') }} LUXSKIN BEAUTY STUDIO</span>
        <span>PRODUCT MANAGEMENT</span>
    </div>
</div>
@stop

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@600;700;800;900;1000&family=Playfair+Display:wght@700;800;900&display=swap');

:root { --pink:#e83e80; --pink-dark:#c92768; --ink:#30212b; --muted:#8f7e89; --border:#f1e5eb; }
.content-wrapper { background:#fff8fb !important; }
.content { padding:24px 25px 35px !important; }
.lux-create,.lux-create * { box-sizing:border-box; }
.lux-create { color:var(--ink); font-family:'Nunito Sans','Segoe UI',sans-serif !important; font-weight:800; -webkit-font-smoothing:antialiased; }
.lux-create p,.lux-create a,.lux-create span,.lux-create small { font-family:'Nunito Sans','Segoe UI',sans-serif; }

.main-sidebar { background:linear-gradient(180deg,#351a2b,#241421) !important; }
.brand-link { padding:22px 16px !important; border-bottom:1px solid #ffffff18 !important; }
.brand-link .brand-text { color:#fff !important; font-family:'Playfair Display',Georgia,serif !important; font-size:23px !important; font-weight:900 !important; letter-spacing:1px; }
.main-sidebar .nav-sidebar .nav-link { margin:4px 11px !important; padding:13px 14px !important; border-radius:11px !important; color:#f8eaf1 !important; font-size:15px !important; font-weight:900 !important; }
.main-sidebar .nav-sidebar .nav-link p { font-size:15px !important; font-weight:900 !important; }
.main-sidebar .nav-sidebar .nav-link:hover,.main-sidebar .nav-sidebar .nav-link.active { color:#fff !important; background:linear-gradient(110deg,#ed4a91,#ca2c70) !important; }
.main-header.navbar { background:#fff !important; border-bottom:1px solid #f3e7ed !important; }

.lux-topbar { display:flex; justify-content:space-between; align-items:center; gap:22px; margin:3px 0 25px; }
.lux-eyebrow { color:var(--pink); margin-bottom:8px; font-size:10px; font-weight:1000; letter-spacing:1.7px; }
.lux-heading h1 { margin:0; color:var(--ink); font-family:'Playfair Display',Georgia,serif !important; font-size:43px; font-weight:900; letter-spacing:-.7px; }
.lux-heading p { color:#806b78; font-size:14px; font-weight:800; margin:10px 0 0; }

.lux-date-card { display:flex; align-items:center; gap:17px; flex:0 0 260px; min-height:124px; padding:17px 20px; border:1px solid #f4c9dc; border-radius:21px; background:#fff; box-shadow:0 12px 30px #55263d0f; }
.lux-date-symbol { display:grid; place-items:center; width:65px; height:65px; flex:0 0 65px; border-radius:18px; background:linear-gradient(145deg,#f75da4,#d91e72); color:#fff; }
.lux-date-symbol span { font-family:'Playfair Display',Georgia,serif !important; font-size:38px; font-weight:900; font-style:italic; }
.lux-date-info { min-width:0; }
.lux-date-label { color:#9b7187; font-size:11px; font-weight:1000; letter-spacing:1px; margin-bottom:5px; }
.lux-date-value { color:#35202d; font-size:20px; font-weight:1000; line-height:1.4; white-space:nowrap; }
.lux-clock { color:#d92775; font-size:14px; font-weight:1000; line-height:1.6; margin-top:3px; font-variant-numeric:tabular-nums; }

.lux-form-hero { padding:27px 31px; margin-bottom:22px; border-radius:18px; color:#fff; background:linear-gradient(110deg,#d92d76,#ed5b99 60%,#f49bbd); box-shadow:0 12px 28px #ce30721a; }
.lux-form-eyebrow { font-size:10px; font-weight:1000; letter-spacing:1.8px; }
.lux-form-hero h2 { margin:10px 0; color:#fff; font-family:'Playfair Display',Georgia,serif !important; font-size:30px; font-weight:900; }
.lux-form-hero p { margin:0; color:#fff; font-size:13px; font-weight:800; line-height:1.8; }

.lux-alert { padding:16px 20px; border-radius:12px; margin-bottom:20px; font-size:13px; font-weight:800; }
.lux-alert-error { border:1px solid #f2c5d3; background:#fff0f3; color:#9c274d; }
.lux-alert ul { margin:8px 0 0; padding-left:22px; }
.lux-alert li { margin:4px 0; }

.lux-form-panel { padding:25px; margin-bottom:20px; border:1px solid #f0e4e9; border-radius:17px; background:#fff; box-shadow:0 5px 19px #481f3408; }
.lux-form-heading { display:flex; align-items:center; gap:13px; padding-bottom:19px; margin-bottom:23px; border-bottom:1px solid #f3e8ee; }
.lux-form-heading-icon { display:grid; place-items:center; width:45px; height:45px; flex:0 0 45px; border-radius:13px; color:#d63378; background:#fff0f6; font-size:17px; }
.lux-form-heading h3 { margin:0; color:#382532; font-family:'Playfair Display',Georgia,serif !important; font-size:22px; font-weight:900; }
.lux-form-heading p { margin:5px 0 0; color:#9b8993; font-size:12px; font-weight:800; }
.lux-form-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:21px 22px; }
.lux-field { min-width:0; }
.lux-field-full { grid-column:1/-1; }
.lux-field label { display:block; margin-bottom:9px; color:#4b3442; font-size:12px; font-weight:1000; }
.lux-field label span { color:#df347c; }
.lux-field input,.lux-field select,.lux-field textarea {
    display:block; width:100%; min-height:46px; padding:11px 13px;
    border:1px solid #eadce4; border-radius:9px; outline:0;
    color:#382532; background:#fff; font-family:'Nunito Sans',sans-serif;
    font-size:13px; font-weight:800; transition:border-color .2s,box-shadow .2s;
}
.lux-field textarea { min-height:100px; resize:vertical; line-height:1.8; }
.lux-field input::placeholder,.lux-field textarea::placeholder { color:#b4a2ad; font-weight:700; }
.lux-field input:focus,.lux-field select:focus,.lux-field textarea:focus {
    border-color:#e83e80; box-shadow:0 0 0 3px #e83e8018;
}
.lux-input-prefix { display:flex; align-items:center; border:1px solid #eadce4; border-radius:9px; overflow:hidden; }
.lux-input-prefix:focus-within { border-color:#e83e80; box-shadow:0 0 0 3px #e83e8018; }
.lux-input-prefix > span { padding:0 13px; color:#d63378; background:#fff5fa; font-size:12px; font-weight:1000; align-self:stretch; display:flex; align-items:center; }
.lux-input-prefix input { border:0; border-radius:0; box-shadow:none !important; }
.lux-hint { display:block; margin-top:7px; color:#a18d99; font-size:11px; font-weight:800; }
.lux-error { display:block; margin-top:7px; color:#c62855; font-size:11px; font-weight:900; }

.lux-form-actions { display:flex; justify-content:flex-end; gap:12px; margin-top:22px; }
.lux-cancel-btn,.lux-save-btn { display:inline-flex; justify-content:center; align-items:center; gap:9px; min-height:45px; padding:12px 19px; border-radius:9px; font-family:'Nunito Sans',sans-serif; font-size:11px; font-weight:1000; text-decoration:none !important; cursor:pointer; }
.lux-cancel-btn { border:1px solid #ead6e1; color:#806b78 !important; background:#fff; }
.lux-cancel-btn:hover { background:#fff5fa; }
.lux-save-btn { border:1px solid #d63378; color:#fff; background:linear-gradient(110deg,#ed4a91,#ca2c70); box-shadow:0 7px 17px #d6337828; }
.lux-save-btn:hover { background:#bd2566; }
.lux-footer { display:flex; justify-content:space-between; gap:12px; padding:21px 2px 0; color:#a28e99; font-size:10px; font-weight:1000; }

@media(max-width:700px) {
    .content { padding:16px 12px 25px !important; }
    .lux-topbar { align-items:stretch; flex-direction:column; gap:17px; }
    .lux-heading h1 { font-size:36px; }
    .lux-date-card { flex-basis:auto; width:100%; max-width:320px; }
    .lux-date-value { font-size:19px; }
    .lux-form-hero { padding:23px 20px; }
    .lux-form-hero h2 { font-size:25px; }
    .lux-form-panel { padding:18px 15px; }
    .lux-form-grid { grid-template-columns:1fr; gap:18px; }
    .lux-field-full { grid-column:auto; }
    .lux-form-heading h3 { font-size:20px; }
    .lux-form-actions { flex-direction:column-reverse; }
    .lux-cancel-btn,.lux-save-btn { width:100%; }
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
