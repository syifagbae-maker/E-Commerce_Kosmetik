@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h2>Edit Brand</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.brands.update', $brand->id_brand) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nama Brand</label>
                    <input type="text" name="nama_brand"
                           class="form-control"
                           value="{{ old('nama_brand', $brand->nama_brand) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $brand->deskripsi) }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Path Logo</label>
                    <input type="text" name="logo"
                           class="form-control"
                           value="{{ old('logo', $brand->logo) }}">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="aktif" @selected($brand->status === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected($brand->status === 'nonaktif')>Nonaktif</option>
                    </select>
                </div>

                <button class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.brands.index') }}"
                   class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection