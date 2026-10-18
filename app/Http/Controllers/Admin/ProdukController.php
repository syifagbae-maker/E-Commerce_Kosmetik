<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProdukController extends Controller
{
    /**
     * Daftar produk.
     */
    public function index(Request $request)
    {
        $totalProduk = DB::table('produk')->count();

        $totalProdukAktif = DB::table('produk')
            ->where('status', 'aktif')
            ->count();

        $totalProdukDraft = DB::table('produk')
            ->where('status', 'draft')
            ->count();

        $query = DB::table('produk')
            ->leftJoin('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
            ->leftJoin('brand', 'produk.id_brand', '=', 'brand.id_brand')
            ->select(
                'produk.*',
                'kategori.nama_kategori',
                'brand.nama_brand'
            );

        if ($request->filled('cari')) {
            $cari = $request->input('cari');

            $query->where(function ($q) use ($cari) {
                $q->where('produk.nama_produk', 'like', "%{$cari}%")
                    ->orWhere('produk.sku', 'like', "%{$cari}%");
            });
        }

        $produk = $query
            ->orderByDesc('produk.id_produk')
            ->paginate(10)
            ->withQueryString();

        return view('admin.produk.index', [
            'produk' => $produk,
            'totalProduk' => $totalProduk,
            'produkAktif' => $totalProdukAktif,
            'produkDraft' => $totalProdukDraft,
        ]);
    }

    /**
     * Form tambah produk.
     */
    public function create()
    {
        $kategori = DB::table('kategori')
            ->orderBy('nama_kategori')
            ->get();

        $brand = DB::table('brand')
            ->orderBy('nama_brand')
            ->get();

        return view('admin.produk.create', compact('kategori', 'brand'));
    }

    /**
     * Simpan produk baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => ['required', 'string', 'max:150'],
            'sku' => ['required', 'string', 'max:100', 'unique:produk,sku'],
            'id_kategori' => ['nullable', 'integer', 'exists:kategori,id_kategori'],
            'id_brand' => ['nullable', 'integer', 'exists:brand,id_brand'],
            'deskripsi' => ['nullable', 'string'],
            'manfaat' => ['nullable', 'string'],
            'cara_pakai' => ['nullable', 'string'],
            'komposisi' => ['nullable', 'string'],
            'jenis_kulit' => ['nullable', 'string', 'max:255'],
            'berat_gram' => ['nullable', 'numeric', 'min:0'],
            'harga' => ['required', 'numeric', 'min:0'],
            'harga_coret' => ['nullable', 'numeric', 'min:0', 'gte:harga'],
            'status' => ['required', Rule::in(['aktif', 'draft'])],
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.max' => 'Nama produk maksimal 150 karakter.',
            'sku.required' => 'SKU produk wajib diisi.',
            'sku.unique' => 'SKU tersebut sudah digunakan produk lain.',
            'id_kategori.exists' => 'Kategori yang dipilih tidak ditemukan.',
            'id_brand.exists' => 'Brand yang dipilih tidak ditemukan.',
            'harga.required' => 'Harga produk wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari nol.',
            'harga_coret.gte' => 'Harga coret harus sama dengan atau lebih tinggi dari harga jual.',
            'status.required' => 'Status produk wajib dipilih.',
            'status.in' => 'Status produk tidak valid.',
        ]);

        $slugDasar = Str::slug($validated['nama_produk']);
        $slug = $slugDasar;
        $nomor = 1;

        while (
            DB::table('produk')
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $slugDasar . '-' . $nomor;
            $nomor++;
        }

        $sekarang = now();

        DB::table('produk')->insert([
            'id_kategori' => $validated['id_kategori'] ?? null,
            'id_brand' => $validated['id_brand'] ?? null,
            'nama_produk' => $validated['nama_produk'],
            'slug' => $slug,
            'sku' => $validated['sku'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'manfaat' => $validated['manfaat'] ?? null,
            'cara_pakai' => $validated['cara_pakai'] ?? null,
            'komposisi' => $validated['komposisi'] ?? null,
            'jenis_kulit' => $validated['jenis_kulit'] ?? null,
            'berat_gram' => $validated['berat_gram'] ?? null,
            'harga' => $validated['harga'],
            'harga_coret' => $validated['harga_coret'] ?? null,
            'status' => $validated['status'],
            'created_at' => $sekarang,
            'updated_at' => $sekarang,
        ]);

        return redirect()
            ->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan ke katalog LuxSkin!');
    }
}
