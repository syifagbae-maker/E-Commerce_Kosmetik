@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h2>Tambah Brand</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.brands.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama Brand</label>
                    <input type="text" name="nama_brand"
                           class="form-control"
                           value="{{ old('nama_brand') }}" required>
                    @error('nama_brand')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Path Logo</label>
                    <input type="text" name="logo"
                           class="form-control"
                           value="{{ old('logo') }}"
                           placeholder="Contoh: images/brands/logo.png">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.brands.index') }}"
                   class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection