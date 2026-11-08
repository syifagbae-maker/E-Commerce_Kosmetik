
@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h2>Tambah Gambar Produk</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.gambar-produk.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Produk</label>
                    <select name="id_produk" class="form-control" required>
                        <option value="">Pilih Produk</option>
                        @foreach($produk as $item)
                            <option value="{{ $item->id_produk }}"
                                @selected(old('id_produk') == $item->id_produk)>
                                {{ $item->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_produk')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>File Gambar</label>
                    <input type="file" name="gambar"
                           class="form-control"
                           accept=".jpg,.jpeg,.png,.webp"
                           required>
                    @error('gambar')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Alt Text</label>
                    <input type="text" name="alt_text"
                           class="form-control"
                           value="{{ old('alt_text') }}">
                </div>

                <div class="mb-3">
                    <label>Urutan</label>
                    <input type="number" name="urutan"
                           class="form-control"
                           min="0" value="{{ old('urutan', 1) }}"
                           required>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="gambar_utama"
                           value="1" class="form-check-input"
                           id="gambar_utama">
                    <label for="gambar_utama" class="form-check-label">
                        Jadikan gambar utama
                    </label>
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.gambar-produk.index') }}"
                   class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
