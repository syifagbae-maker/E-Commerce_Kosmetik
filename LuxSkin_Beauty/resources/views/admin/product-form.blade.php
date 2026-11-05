@extends('admin.layout')
@section('content')
<span class="eyebrow">KATALOG TOKO</span>
<h1>{{ $product ? 'Edit produk' : 'Tambah produk' }}</h1>
<p class="muted">Isi informasi produk dan pilih foto dari komputer. Foto akan tampil otomatis di katalog pelanggan.</p>
<form class="form-panel" method="POST" enctype="multipart/form-data" action="{{ $product ? route('admin.products.update',$product->id_produk) : route('admin.products.store') }}">
    @csrf
    @if($product) @method('PUT') @endif
    <div class="form-grid">
        <label>Nama produk<input name="nama_produk" value="{{ old('nama_produk',$product->nama_produk??'') }}" required></label>
        <label>SKU<input name="sku" value="{{ old('sku',$product->sku??'') }}" required></label>
        <label>Kategori<select name="id_kategori" required>@foreach($categories as $c)<option value="{{ $c->id_kategori }}" @selected(old('id_kategori',$product->id_kategori??'')==$c->id_kategori)>{{ $c->nama_kategori }}</option>@endforeach</select></label>
        <label>Brand<select name="id_brand" required>@foreach($brands as $b)<option value="{{ $b->id_brand }}" @selected(old('id_brand',$product->id_brand??'')==$b->id_brand)>{{ $b->nama_brand }}</option>@endforeach</select></label>
        <label>Harga jual<input type="number" name="harga" min="0" value="{{ old('harga',$product->harga??'') }}" required></label>
        <label>Harga sebelum diskon<input type="number" name="harga_coret" min="0" value="{{ old('harga_coret',$product->harga_coret??'') }}"></label>
        <label>Berat (gram)<input type="number" name="berat_gram" min="0" value="{{ old('berat_gram',$product->berat_gram??0) }}"></label>
        <label>Jumlah stok<input type="number" name="jumlah_stok" min="0" value="{{ old('jumlah_stok',$product->jumlah_stok??0) }}" required></label>
        <label>Jenis kulit/rambut<input name="jenis_kulit" value="{{ old('jenis_kulit',$product->jenis_kulit??'') }}"></label>
        <label>Status<select name="status"><option value="aktif" @selected(old('status',$product->status??'aktif')==='aktif')>Aktif</option><option value="draft" @selected(old('status',$product->status??'')==='draft')>Draft</option><option value="nonaktif" @selected(old('status',$product->status??'')==='nonaktif')>Nonaktif</option></select></label>
        <label class="wide">Foto produk (bisa pilih beberapa foto)<input type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple><small>Format JPG, PNG, WEBP. Maksimal 4 MB per foto dan 8 foto per penyimpanan. Foto pertama menjadi foto utama jika produk belum memiliki foto.</small></label>
        @if($product && $product->path_gambar)<div class="wide"><small>Foto utama saat ini</small><br><img class="admin-preview" src="{{ $product->path_gambar }}" alt="{{ $product->nama_produk }}"></div>@endif
        <label class="wide">Deskripsi<textarea name="deskripsi">{{ old('deskripsi',$product->deskripsi??'') }}</textarea></label>
        <label class="wide">Manfaat<textarea name="manfaat">{{ old('manfaat',$product->manfaat??'') }}</textarea></label>
        <label class="wide">Cara pakai<textarea name="cara_pakai">{{ old('cara_pakai',$product->cara_pakai??'') }}</textarea></label>
        <label class="wide">Komposisi<textarea name="komposisi">{{ old('komposisi',$product->komposisi??'') }}</textarea></label>
    </div>
    <div class="form-actions"><a class="btn light" href="{{ route('admin.products') }}">Batal</a><button type="submit" class="btn dark">Simpan produk</button></div>
</form>
@endsection
