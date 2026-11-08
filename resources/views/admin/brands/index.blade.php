@extends('admin.layout')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <div>
            <h2>Manajemen Brand</h2>
            <p>Kelola brand kosmetik LuxSkin Beauty.</p>
        </div>

        <a href="{{ route('admin.brands.create') }}"
           class="btn btn-primary">
            + Tambah Brand
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Brand</th>
                        <th>Slug</th>
                        <th>Logo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($brands as $brand)
                    <tr>
                        <td>{{ $brands->firstItem() + $loop->index }}</td>
                        <td>{{ $brand->nama_brand }}</td>
                        <td>{{ $brand->slug }}</td>
                        <td>{{ $brand->logo ?? '-' }}</td>
                        <td>{{ ucfirst($brand->status) }}</td>
                        <td>
                            <a href="{{ route('admin.brands.edit', $brand->id_brand) }}"
                               class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('admin.brands.destroy', $brand->id_brand) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus brand ini?')">
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
                        <td colspan="6" class="text-center">
                            Belum ada data brand.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $brands->links() }}
        </div>
    </div>
</div>
@endsection