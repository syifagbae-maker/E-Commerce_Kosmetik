<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    private function uid(Request $r)
    {
        return $r->session()->get('user.id');
    }

    // HOMEPAGE
    public function home()
    {
        $products = DB::table('produk as p')
            ->leftJoin('brand as b', 'b.id_brand', '=', 'p.id_brand')
            ->leftJoin('kategori as k', 'k.id_kategori', '=', 'p.id_kategori')
            ->where('p.status', 'aktif')
            ->select(
                'p.*',
                'b.nama_brand',
                'k.nama_kategori'
            )
            ->addSelect([
                'path_gambar' => DB::table('gambar_produk as g')
                    ->select('g.path_gambar')
                    ->whereColumn('g.id_produk', 'p.id_produk')
                    ->orderByDesc('g.gambar_utama')
                    ->orderBy('g.urutan')
                    ->orderBy('g.id_gambar')
                    ->limit(1)
            ])
            ->orderByDesc('p.id_produk')
            ->limit(12)
            ->get();

        $categories = DB::table('kategori')
            ->where('status', 'aktif')
            ->orderBy('nama_kategori')
            ->get();

        $brands = DB::table('brand')
            ->orderBy('nama_brand')
            ->get();

        return view('store.home', compact(
            'products',
            'categories',
            'brands'
        ));
    }

    // KATALOG PRODUK
    public function catalog(Request $r)
    {
        $q = DB::table('produk as p')
            ->leftJoin('brand as b', 'b.id_brand', '=', 'p.id_brand')
            ->leftJoin('kategori as k', 'k.id_kategori', '=', 'p.id_kategori')
            ->leftJoin('stok_produk as s', 's.id_produk', '=', 'p.id_produk')
            ->where('p.status', 'aktif')
            ->select(
                'p.*',
                'b.nama_brand',
                'b.slug as brand_slug',
                'k.nama_kategori',
                'k.slug as kategori_slug',
                's.jumlah_stok'
            )
            ->addSelect([
                'path_gambar' => DB::table('gambar_produk as g')
                    ->select('g.path_gambar')
                    ->whereColumn('g.id_produk', 'p.id_produk')
                    ->orderByDesc('g.gambar_utama')
                    ->orderBy('g.urutan')
                    ->orderBy('g.id_gambar')
                    ->limit(1)
            ]);

        // Pencarian nama produk
        if ($r->filled('q')) {
            $q->where(
                'p.nama_produk',
                'like',
                '%' . $r->input('q') . '%'
            );
        }

        // Filter kategori
        if ($r->filled('kategori')) {
            $q->where('k.slug', $r->input('kategori'));
        }

        // Filter brand
        if ($r->filled('brand')) {
            $q->where('b.slug', $r->input('brand'));
        }

        // Filter produk promo
        if ($r->input('koleksi') === 'promo') {
            $q->whereNotNull('p.harga_coret')
                ->whereColumn('p.harga_coret', '>', 'p.harga');
        }

        // Pengurutan produk
        if ($r->input('sort') === 'murah') {
            $q->orderBy('p.harga', 'asc');
        } elseif ($r->input('sort') === 'mahal') {
            $q->orderBy('p.harga', 'desc');
        } else {
            $q->orderByDesc('p.id_produk');
        }

        $products = $q->paginate(12)->withQueryString();

        $categories = DB::table('kategori')
            ->where('status', 'aktif')
            ->orderBy('nama_kategori')
            ->get();

        $brands = DB::table('brand')
            ->orderBy('nama_brand')
            ->get();

        return view('store.catalog', compact(
            'products',
            'categories',
            'brands'
        ));
    }

    // DETAIL PRODUK
    public function product($slug)
    {
        $product = DB::table('produk as p')
            ->join('brand as b', 'b.id_brand', '=', 'p.id_brand')
            ->join('kategori as k', 'k.id_kategori', '=', 'p.id_kategori')
            ->leftJoin('stok_produk as s', 's.id_produk', '=', 'p.id_produk')
            ->where('p.slug', $slug)
            ->where('p.status', 'aktif')
            ->select(
                'p.*',
                'b.nama_brand',
                'k.nama_kategori',
                's.jumlah_stok'
            )
            ->first();

        abort_if(!$product, 404);

        $images = DB::table('gambar_produk')
            ->where('id_produk', $product->id_produk)
            ->orderByDesc('gambar_utama')
            ->orderBy('urutan')
            ->orderBy('id_gambar')
            ->get();

        $reviews = DB::table('ulasan_produk as u')
            ->join('users as x', 'x.id_user', '=', 'u.id_user')
            ->where('u.id_produk', $product->id_produk)
            ->where('u.status', 'ditampilkan')
            ->select('u.*', 'x.nama')
            ->latest('u.created_at')
            ->get();

        return view('store.product', compact(
            'product',
            'images',
            'reviews'
        ));
    }

    // TAMBAH KE KERANJANG
    public function addCart(Request $r, $id)
    {
        $uid = $this->uid($r);

        if (!$uid) {
            return redirect()->route('login')
                ->with(
                    'error',
                    'Masuk terlebih dahulu untuk menambahkan produk ke keranjang.'
                );
        }

        $r->validate([
            'jumlah' => 'nullable|integer|min:1|max:20'
        ]);

        $p = DB::table('produk')
            ->where('id_produk', $id)
            ->where('status', 'aktif')
            ->first();

        abort_if(!$p, 404);

        $stock = DB::table('stok_produk')
            ->where('id_produk', $id)
            ->value('jumlah_stok') ?? 0;

        $qty = (int) $r->input('jumlah', 1);

        if ($stock < $qty) {
            return back()->with(
                'error',
                'Stok produk tidak mencukupi.'
            );
        }

        $cart = DB::table('keranjang')
            ->where('id_user', $uid)
            ->where('status', 'aktif')
            ->first();

        $cid = $cart?->id_keranjang
            ?? DB::table('keranjang')->insertGetId([
                'id_user' => $uid,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ]);

        $line = DB::table('detail_keranjang')
            ->where('id_keranjang', $cid)
            ->where('id_produk', $id)
            ->first();

        if ($line) {
            if (($line->jumlah + $qty) > $stock) {
                return back()->with(
                    'error',
                    'Jumlah melebihi stok tersedia.'
                );
            }

            DB::table('detail_keranjang')
                ->where(
                    'id_detail_keranjang',
                    $line->id_detail_keranjang
                )
                ->update([
                    'jumlah' => $line->jumlah + $qty,
                    'updated_at' => now()
                ]);
        } else {
            DB::table('detail_keranjang')->insert([
                'id_keranjang' => $cid,
                'id_produk' => $id,
                'jumlah' => $qty,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()->route('cart')
            ->with(
                'success',
                'Produk berhasil masuk ke keranjang.'
            );
    }

    // KERANJANG
    public function cart(Request $r)
    {
        $uid = $this->uid($r);

        if (!$uid) {
            return redirect()->route('login');
        }

        $cart = DB::table('keranjang')
            ->where('id_user', $uid)
            ->where('status', 'aktif')
            ->first();

        $items = $cart
            ? DB::table('detail_keranjang as d')
                ->join('produk as p', 'p.id_produk', '=', 'd.id_produk')
                ->leftJoin('stok_produk as s', 's.id_produk', '=', 'p.id_produk')
                ->where('d.id_keranjang', $cart->id_keranjang)
                ->select(
                    'd.*',
                    'p.nama_produk',
                    'p.slug',
                    'p.harga',
                    's.jumlah_stok'
                )
                ->addSelect([
                    'path_gambar' => DB::table('gambar_produk as g')
                        ->select('g.path_gambar')
                        ->whereColumn('g.id_produk', 'p.id_produk')
                        ->orderByDesc('g.gambar_utama')
                        ->orderBy('g.urutan')
                        ->orderBy('g.id_gambar')
                        ->limit(1)
                ])
                ->get()
            : collect();

        return view('store.cart', compact('items'));
    }

    // UPDATE KERANJANG
    public function updateCart(Request $r, $id)
    {
        $r->validate([
            'jumlah' => 'required|integer|min:1|max:20'
        ]);

        $uid = $this->uid($r);

        $line = DB::table('detail_keranjang as d')
            ->join('keranjang as k', 'k.id_keranjang', '=', 'd.id_keranjang')
            ->where('d.id_detail_keranjang', $id)
            ->where('k.id_user', $uid)
            ->select('d.*')
            ->first();

        if ($line) {
            DB::table('detail_keranjang')
                ->where('id_detail_keranjang', $id)
                ->update([
                    'jumlah' => $r->jumlah,
                    'updated_at' => now()
                ]);
        }

        return back()->with(
            'success',
            'Keranjang diperbarui.'
        );
    }

    // HAPUS DARI KERANJANG
    public function removeCart(Request $r, $id)
    {
        $uid = $this->uid($r);

        DB::table('detail_keranjang as d')
            ->join('keranjang as k', 'k.id_keranjang', '=', 'd.id_keranjang')
            ->where('d.id_detail_keranjang', $id)
            ->where('k.id_user', $uid)
            ->delete();

        return back()->with(
            'success',
            'Produk dihapus dari keranjang.'
        );
    }

    // ALAMAT CUSTOMER
    public function addresses(Request $r)
    {
        $uid = $this->uid($r);

        if (!$uid) {
            return redirect()->route('login');
        }

        $addresses = DB::table('alamat')
            ->where('id_user', $uid)
            ->orderByDesc('alamat_utama')
            ->get();

        return view('account.addresses', compact('addresses'));
    }

    // SIMPAN ALAMAT
    public function saveAddress(Request $r)
    {
        $uid = $this->uid($r);

        $d = $r->validate([
            'label_alamat' => 'required|max:50',
            'nama_penerima' => 'required|max:100',
            'no_hp_penerima' => 'required|max:20',
            'provinsi' => 'required|max:100',
            'kota' => 'required|max:100',
            'kecamatan' => 'required|max:100',
            'kode_pos' => 'required|max:10',
            'alamat_lengkap' => 'required'
        ]);

        DB::table('alamat')->insert($d + [
            'id_user' => $uid,
            'alamat_utama' => DB::table('alamat')
                ->where('id_user', $uid)
                ->exists() ? 0 : 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with(
            'success',
            'Alamat berhasil disimpan.'
        );
    }

    // CHECKOUT
    public function checkout(Request $r)
    {
        $uid = $this->uid($r);

        if (!$uid) {
            return redirect()->route('login');
        }

        $cart = DB::table('keranjang')
            ->where('id_user', $uid)
            ->where('status', 'aktif')
            ->first();

        $items = $cart
            ? DB::table('detail_keranjang as d')
                ->join('produk as p', 'p.id_produk', '=', 'd.id_produk')
                ->where('d.id_keranjang', $cart->id_keranjang)
                ->select(
                    'd.*',
                    'p.nama_produk',
                    'p.sku',
                    'p.harga'
                )
                ->get()
            : collect();

        $addresses = DB::table('alamat')
            ->where('id_user', $uid)
            ->get();

        $methods = DB::table('metode_pembayaran')
            ->where('status', 'aktif')
            ->get();

        $couriers = DB::table('kurir')
            ->where('status', 'aktif')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart')
                ->with(
                    'error',
                    'Keranjang masih kosong.'
                );
        }

        if ($addresses->isEmpty()) {
            return redirect()->route('addresses')
                ->with(
                    'error',
                    'Tambahkan alamat rumah sebelum checkout.'
                );
        }

        return view('store.checkout', compact(
            'items',
            'addresses',
            'methods',
            'couriers'
        ));
    }

    // PROSES PESANAN
    public function placeOrder(Request $r)
    {
        $uid = $this->uid($r);

        if (!$uid) {
            return redirect()->route('login');
        }

        $d = $r->validate([
            'id_alamat' => 'required|integer|exists:alamat,id_alamat',
            'id_metode' => 'required|integer|exists:metode_pembayaran,id_metode',
            'id_kurir' => 'required|integer|exists:kurir,id_kurir',
            'catatan_pesanan' => 'nullable|max:1000'
        ]);

        if (!DB::table('alamat')
            ->where('id_alamat', $d['id_alamat'])
            ->where('id_user', $uid)
            ->exists()) {
            return back()->withErrors([
                'id_alamat' => 'Alamat tidak valid.'
            ]);
        }

        if (!DB::table('metode_pembayaran')
            ->where('id_metode', $d['id_metode'])
            ->where('status', 'aktif')
            ->exists()
            || !DB::table('kurir')
                ->where('id_kurir', $d['id_kurir'])
                ->where('status', 'aktif')
                ->exists()) {
            return back()->withErrors([
                'id_metode' => 'Metode pembayaran atau kurir tidak tersedia.'
            ]);
        }

        $cart = DB::table('keranjang')
            ->where('id_user', $uid)
            ->where('status', 'aktif')
            ->first();

        if (!$cart) {
            return redirect()->route('cart');
        }

        $lines = DB::table('detail_keranjang as d')
            ->join('produk as p', 'p.id_produk', '=', 'd.id_produk')
            ->where('d.id_keranjang', $cart->id_keranjang)
            ->select(
                'd.*',
                'p.nama_produk',
                'p.sku',
                'p.harga'
            )
            ->get();

        if ($lines->isEmpty()) {
            return redirect()->route('cart');
        }

        foreach ($lines as $line) {
            $available = (int) (
                DB::table('stok_produk')
                    ->where('id_produk', $line->id_produk)
                    ->value('jumlah_stok') ?? 0
            );

            if ($available < $line->jumlah) {
                return redirect()->route('cart')
                    ->with(
                        'error',
                        'Stok ' . $line->nama_produk . ' tidak mencukupi.'
                    );
            }
        }

        $subtotal = $lines->sum(
            fn($x) => $x->jumlah * $x->harga
        );

        $invoice = 'LS-' . now()->format('ymd') . '-'
            . strtoupper(\Illuminate\Support\Str::random(6));

        $status = DB::table('status_pesanan')
            ->where('kode_status', 'menunggu_pembayaran')
            ->value('id_status') ?? 1;

        $pid = DB::table('pesanan')->insertGetId([
            'no_invoice' => $invoice,
            'id_user' => $uid,
            'id_alamat' => $d['id_alamat'],
            'id_status' => $status,
            'tanggal_pesanan' => now(),
            'subtotal' => $subtotal,
            'diskon' => 0,
            'ongkir' => 15000,
            'total_harga' => $subtotal + 15000,
            'catatan_pesanan' => $d['catatan_pesanan'] ?? null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        foreach ($lines as $line) {
            DB::table('detail_pesanan')->insert([
                'id_pesanan' => $pid,
                'id_produk' => $line->id_produk,
                'nama_produk_saat_beli' => $line->nama_produk,
                'sku_saat_beli' => $line->sku,
                'jumlah' => $line->jumlah,
                'harga_satuan' => $line->harga,
                'subtotal' => $line->jumlah * $line->harga,
                'created_at' => now()
            ]);

            DB::table('stok_produk')
                ->where('id_produk', $line->id_produk)
                ->decrement('jumlah_stok', $line->jumlah);
        }

        DB::table('pembayaran')->insert([
            'id_pesanan' => $pid,
            'id_metode' => $d['id_metode'],
            'jumlah_bayar' => $subtotal + 15000,
            'status_pembayaran' => 'menunggu',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('pengiriman')->insert([
            'id_pesanan' => $pid,
            'id_kurir' => $d['id_kurir'],
            'biaya_pengiriman' => 15000,
            'status_pengiriman' => 'menunggu',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('riwayat_status_pesanan')->insert([
            'id_pesanan' => $pid,
            'id_status' => $status,
            'keterangan' => 'Pesanan dibuat',
            'waktu_status' => now()
        ]);

        DB::table('notifikasi')->insert([
            'id_user' => $uid,
            'id_pesanan' => $pid,
            'judul' => 'Pesanan diterima',
            'pesan' => 'Pesanan ' . $invoice . ' berhasil dibuat. Silakan selesaikan pembayaran.',
            'jenis_notifikasi' => 'pesanan',
            'sudah_dibaca' => 0,
            'created_at' => now()
        ]);

        DB::table('keranjang')
            ->where('id_keranjang', $cart->id_keranjang)
            ->update([
                'status' => 'checkout',
                'updated_at' => now()
            ]);

        return redirect()->route('orders')
            ->with(
                'success',
                'Checkout berhasil! Nomor pesanan: ' . $invoice
            );
    }

    // UPLOAD BUKTI PEMBAYARAN
    public function paymentProof(Request $r, $id)
    {
        $uid = $this->uid($r);

        $r->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'nomor_referensi' => 'nullable|string|max:100'
        ]);

        $order = DB::table('pesanan')
            ->where('id_pesanan', $id)
            ->where('id_user', $uid)
            ->first();

        abort_if(!$order, 404);

        $payment = DB::table('pembayaran')
            ->where('id_pesanan', $id)
            ->first();

        abort_if(!$payment, 404);

        $path = $r->file('bukti_pembayaran')
            ->store('payment-proofs', 'public');

        DB::table('pembayaran')
            ->where('id_pesanan', $id)
            ->update([
                'bukti_pembayaran' => '/storage/' . $path,
                'nomor_referensi' => $r->input('nomor_referensi'),
                'updated_at' => now(),
                'catatan' => 'Bukti pembayaran diunggah pelanggan'
            ]);

        return back()->with(
            'success',
            'Bukti pembayaran berhasil dikirim. Menunggu konfirmasi admin.'
        );
    }

    // RIWAYAT PESANAN
    public function orders(Request $r)
    {
        $uid = $this->uid($r);

        if (!$uid) {
            return redirect()->route('login');
        }

        $orders = DB::table('pesanan as p')
            ->join('status_pesanan as s', 's.id_status', '=', 'p.id_status')
            ->where('p.id_user', $uid)
            ->leftJoin('pembayaran as pay', 'pay.id_pesanan', '=', 'p.id_pesanan')
            ->leftJoin('metode_pembayaran as mp', 'mp.id_metode', '=', 'pay.id_metode')
            ->select(
                'p.*',
                's.nama_status',
                'pay.status_pembayaran',
                'pay.bukti_pembayaran',
                'pay.id_metode',
                'mp.nama_metode',
                'mp.jenis_metode',
                'mp.instruksi'
            )
            ->latest('p.tanggal_pesanan')
            ->get();

        return view('account.orders', compact('orders'));
    }


    // HALAMAN NEW ARRIVALS
    public function newArrivals()
    {
        $products = DB::table('produk as p')
            ->leftJoin('brand as b', 'b.id_brand', '=', 'p.id_brand')
            ->leftJoin('kategori as k', 'k.id_kategori', '=', 'p.id_kategori')
            ->where('p.status', 'aktif')
            ->select('p.*', 'b.nama_brand', 'k.nama_kategori')
            ->addSelect([
                'path_gambar' => DB::table('gambar_produk as g')
                    ->select('g.path_gambar')
                    ->whereColumn('g.id_produk', 'p.id_produk')
                    ->orderByDesc('g.gambar_utama')
                    ->orderBy('g.urutan')
                    ->orderBy('g.id_gambar')
                    ->limit(1)
            ])
            ->orderByDesc('p.id_produk')
            ->paginate(12);

        return view('store.new-arrivals', compact('products'));
    }

    // HALAMAN BRANDS
    public function brands()
    {
        $brands = DB::table('brand')
            ->orderBy('nama_brand')
            ->get();

        return view('store.brands', compact('brands'));
    }

    // HALAMAN CATEGORIES
    public function categories()
    {
        $categories = DB::table('kategori')
            ->where('status', 'aktif')
            ->orderBy('nama_kategori')
            ->get();

        return view('store.categories', compact('categories'));
    }

    // HALAMAN PROMOTIONS
    public function promotions()
    {
        $products = DB::table('produk as p')
            ->leftJoin('brand as b', 'b.id_brand', '=', 'p.id_brand')
            ->leftJoin('kategori as k', 'k.id_kategori', '=', 'p.id_kategori')
            ->where('p.status', 'aktif')
            ->whereNotNull('p.harga_coret')
            ->whereColumn('p.harga_coret', '>', 'p.harga')
            ->select('p.*', 'b.nama_brand', 'k.nama_kategori')
            ->addSelect([
                'path_gambar' => DB::table('gambar_produk as g')
                    ->select('g.path_gambar')
                    ->whereColumn('g.id_produk', 'p.id_produk')
                    ->orderByDesc('g.gambar_utama')
                    ->orderBy('g.urutan')
                    ->orderBy('g.id_gambar')
                    ->limit(1)
            ])
            ->orderByDesc('p.id_produk')
            ->paginate(12);

        return view('store.promotions', compact('products'));
    }

}
