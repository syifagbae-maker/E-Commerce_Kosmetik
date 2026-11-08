
@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h2>Edit Gambar Produk</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.gambar-produk.update', $gambar->id_gambar) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Produk</label>
                    <select name="id_produk" class="form-control" required>
                        @foreach($produk as $item)
                            <option value="{{ $item->id_produk }}"
                                @selected(old('id_produk', $gambar->id_produk) == $item->id_produk)>
                                {{ $item->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Gambar Saat Ini</label><br>
                    <img src="{{ asset('storage/' . $gambar->path_gambar) }}"
                         width="120" alt="{{ $gambar->alt_text }}">
                </div>

                <div class="mb-3">
                    <label>Ganti Gambar (Opsional)</label>
                    <input type="file" name="gambar"
                           class="form-control"
                           accept=".jpg,.jpeg,.png,.webp">
                </div>

                <div class="mb-3">
                    <label>Alt Text</label>
                    <input type="text" name="alt_text"
                           class="form-control"
                           value="{{ old('alt_text', $gambar->alt_text) }}">
                </div>

                <div class="mb-3">
                    <label>Urutan</label>
                    <input type="number" name="urutan"
                           class="form-control"
                           min="0"
                           value="{{ old('urutan', $gambar->urutan) }}"
                           required>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="gambar_utama"
                           value="1" class="form-check-input"
                           id="gambar_utama"
                           @checked(old('gambar_utama', $gambar->gambar_utama))>
                    <label for="gambar_utama" class="form-check-label">
                        Jadikan gambar utama
                    </label>
                </div>

                <button class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.gambar-produk.index') }}"
                   class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
