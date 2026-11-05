@extends('admin.layout')
@section('content')
<span class="eyebrow">PENGELOLAAN TRANSAKSI</span><h1>Pesanan pelanggan</h1>
<p class="muted">Periksa pembayaran, konfirmasi transaksi, dan perbarui status pesanan.</p>
<div class="admin-panel table-wrap"><table><thead><tr><th>Invoice</th><th>Pelanggan</th><th>Total</th><th>Metode bayar</th><th>Pembayaran</th><th>Bukti</th><th>Status pesanan</th><th>Aksi</th></tr></thead><tbody>
@forelse($orders as $o)
<tr><td><b>{{ $o->no_invoice }}</b><br><small>{{ $o->tanggal_pesanan }}</small></td><td>{{ $o->nama }}<br><small>{{ $o->email }}</small></td><td>Rp{{ number_format($o->total_harga,0,',','.') }}</td><td>{{ $o->nama_metode ?? '—' }}</td><td>{{ ucfirst($o->status_pembayaran ?? 'menunggu') }}</td><td>@if($o->bukti_pembayaran)<a class="action-link" href="{{ $o->bukti_pembayaran }}" target="_blank">Lihat bukti</a>@else Belum ada @endif</td><td>{{ $o->nama_status }}</td><td>
@if(($o->status_pembayaran ?? '') !== 'berhasil')<form method="POST" action="{{ route('admin.payment.confirm',$o->id_pesanan) }}">@csrf<button class="small-btn" type="submit">Konfirmasi bayar</button></form>@endif
<form method="POST" action="{{ route('admin.orders.update',$o->id_pesanan) }}">@csrf @method('PATCH')<select name="id_status">@foreach($statuses as $s)<option value="{{ $s->id_status }}" @selected($s->id_status==$o->id_status)>{{ $s->nama_status }}</option>@endforeach</select><button class="small-btn" type="submit">Update status</button></form>
</td></tr>
@empty<tr><td colspan="8">Belum ada pesanan.</td></tr>@endforelse
</tbody></table>{{ $orders->links() }}</div>
@endsection
