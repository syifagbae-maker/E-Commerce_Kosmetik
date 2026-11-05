<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('nama_brand')->paginate(10);

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_brand' => 'required|string|max:100|unique:brand,nama_brand',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $data['slug'] = Str::slug($data['nama_brand']);

        Brand::create($data);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);

        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $data = $request->validate([
            'nama_brand' => [
                'required',
                'string',
                'max:100',
                Rule::unique('brand', 'nama_brand')
                    ->ignore($brand->id_brand, 'id_brand'),
            ],
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $data['slug'] = Str::slug($data['nama_brand']);

        $brand->update($data);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Brand::findOrFail($id)->delete();

        return back()->with('success', 'Brand berhasil dihapus.');
    }
}
