
@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <div>
            <h2>Gambar Produk</h2>
            <p>Kelola foto produk kosmetik.</p>
        </div>

        <a href="{{ route('admin.gambar-produk.create') }}"
           class="btn btn-primary">
            + Tambah Gambar
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Produk</th>
                        <th>Gambar</th>
                        <th>Alt Text</th>
                        <th>Gambar Utama</th>
                        <th>Urutan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gambar as $item)
                    <tr>
                        <td>{{ $gambar->firstItem() + $loop->index }}</td>
                        <td>{{ $item->produk->nama_produk ?? '-' }}</td>
                        <td>
                            <img
                                src="{{ asset('storage/' . $item->path_gambar) }}"
                                alt="{{ $item->alt_text }}"
                                width="75"
                                height="75"
                                style="object-fit: cover;"
                            >
                        </td>
                        <td>{{ $item->alt_text ?? '-' }}</td>
                        <td>
                            {{ $item->gambar_utama ? 'Ya' : 'Tidak' }}
                        </td>
                        <td>{{ $item->urutan }}</td>
                        <td>
                            <a href="{{ route('admin.gambar-produk.edit', $item->id_gambar) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form
                                action="{{ route('admin.gambar-produk.destroy', $item->id_gambar) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Hapus gambar ini?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada gambar produk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $gambar->links() }}
        </div>
    </div>
</div>
@endsection
