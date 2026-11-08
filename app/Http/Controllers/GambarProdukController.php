<?php

namespace App\Http\Controllers;

use App\Models\GambarProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GambarProdukController extends Controller
{
    public function index()
    {
        $gambar = GambarProduk::with('produk')
            ->orderBy('id_produk')
            ->orderBy('urutan')
            ->paginate(10);

        return view('admin.gambar-produk.index', compact('gambar'));
    }

    public function create()
    {
        $produk = Produk::orderBy('nama_produk')->get();

        return view('admin.gambar-produk.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'gambar_utama' => 'nullable|boolean',
            'urutan' => 'required|integer|min:0',
        ]);

        $data['path_gambar'] = $request->file('gambar')
            ->store('gambar-produk', 'public');

        unset($data['gambar']);

        $data['gambar_utama'] = $request->boolean('gambar_utama');

        if ($data['gambar_utama']) {
            GambarProduk::where('id_produk', $data['id_produk'])
                ->update(['gambar_utama' => 0]);
        }

        GambarProduk::create($data);

        return redirect()->route('admin.gambar-produk.index')
            ->with('success', 'Gambar produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $gambar = GambarProduk::findOrFail($id);
        $produk = Produk::orderBy('nama_produk')->get();

        return view(
            'admin.gambar-produk.edit',
            compact('gambar', 'produk')
        );
    }

    public function update(Request $request, $id)
    {
        $gambar = GambarProduk::findOrFail($id);

        $data = $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'gambar_utama' => 'nullable|boolean',
            'urutan' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('gambar')) {
            if ($gambar->path_gambar) {
                Storage::disk('public')->delete($gambar->path_gambar);
            }

            $data['path_gambar'] = $request->file('gambar')
                ->store('gambar-produk', 'public');
        }

        unset($data['gambar']);

        $data['gambar_utama'] = $request->boolean('gambar_utama');

        if ($data['gambar_utama']) {
            GambarProduk::where('id_produk', $data['id_produk'])
                ->where('id_gambar', '!=', $gambar->id_gambar)
                ->update(['gambar_utama' => 0]);
        }

        $gambar->update($data);

        return redirect()->route('admin.gambar-produk.index')
            ->with('success', 'Gambar produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $gambar = GambarProduk::findOrFail($id);

        if ($gambar->path_gambar) {
            Storage::disk('public')->delete($gambar->path_gambar);
        }

        $gambar->delete();

        return back()->with('success', 'Gambar produk berhasil dihapus.');
    }
}
