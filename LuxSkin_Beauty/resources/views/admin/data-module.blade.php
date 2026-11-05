@extends('admin.layout')
@section('content')
<span class="eyebrow">PENGELOLAAN DATABASE</span>
<h1>{{ $module['title'] }}</h1>
<p class="muted">Data dari tabel <code>{{ $table }}</code> pada database LuxSkin Beauty.</p>
<div class="admin-panel">
    <h2>Tambah data</h2>
    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.data.store',$table) }}" class="form-grid">
        @csrf
        @foreach($module['fields'] as $field=>$label)
            <label>{{ $label }}
                @if($table === 'gambar_produk' && $field === 'path_gambar')
                    <input type="file" name="gambar_file" accept="image/jpeg,image/png,image/webp" required>
                    <small>Pilih foto dari komputer, maksimal 4 MB.</small>
                @elseif(str_contains($field,'deskripsi') || str_contains($field,'alamat_lengkap') || $field==='pesan' || $field==='komentar' || $field==='instruksi')
                    <textarea name="{{ $field }}"></textarea>
                @else
                    <input name="{{ $field }}" @if(str_contains($field,'status')) value="aktif" @endif>
                @endif
            </label>
        @endforeach
        @if($table==='users')<label>Password sementara<input type="password" name="password" minlength="8" required></label>@endif
        <div class="wide"><button type="submit" class="btn dark">Simpan data</button></div>
    </form>
</div>
<div class="admin-panel table-wrap">
    <h2>Data tersimpan</h2>
    <table><thead><tr><th>ID</th>@foreach($module['fields'] as $label)<th>{{ $label }}</th>@endforeach<th>Aksi</th></tr></thead><tbody>
    @forelse($rows as $row)
        <tr><td>{{ $row->{$module['pk']} }}</td>
        @foreach($module['fields'] as $field=>$label)
            <td>@if($table==='gambar_produk' && $field==='path_gambar')<img class="admin-thumb" src="{{ $row->{$field} }}" alt="{{ $row->alt_text ?? 'Foto produk' }}">@else{{ \Illuminate\Support\Str::limit((string)($row->{$field}??'—'),70) }}@endif</td>
        @endforeach
        <td><details><summary class="action-link">Edit</summary><form method="POST" enctype="multipart/form-data" action="{{ route('admin.data.update',[$table,$row->{$module['pk']}]) }}" class="module-edit-form">@csrf @method('PUT')
            @foreach($module['fields'] as $field=>$label)<label>{{ $label }}@if($table==='gambar_produk' && $field==='path_gambar')<input type="file" name="gambar_file" accept="image/jpeg,image/png,image/webp"><small>Kosongkan jika tidak mengganti foto.</small>@else<input name="{{ $field }}" value="{{ $row->{$field}??'' }}">@endif</label>@endforeach
            <button type="submit" class="small-btn">Simpan</button></form></details>
        <form method="POST" action="{{ route('admin.data.delete',[$table,$row->{$module['pk']}]) }}">@csrf @method('DELETE')<button class="text-danger" onclick="return confirm('Hapus data ini?')">Hapus</button></form></td></tr>
    @empty<tr><td colspan="{{ count($module['fields'])+2 }}">Belum ada data.</td></tr>@endforelse
    </tbody></table>{{ $rows->links() }}
</div>
@endsection
