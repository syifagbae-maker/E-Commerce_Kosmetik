@extends('layouts.app')
@section('title','Pesanan saya — LuxSkin')
@section('content')
<section class="section narrow"><span class="eyebrow">RIWAYAT BELANJA</span><h1>Pesanan saya</h1>
@forelse($orders as $o)
<div class="order-card"><div><small>{{ $o->no_invoice }} · {{ date('d M Y',strtotime($o->tanggal_pesanan)) }}</small><h3>{{ $o->nama_status }}</h3><span>Total Rp{{ number_format($o->total_harga,0,',','.') }}</span><p>Metode: <b>{{ $o->nama_metode ?? '—' }}</b> · Status pembayaran: <b>{{ ucfirst($o->status_pembayaran ?? 'menunggu') }}</b></p>@if($o->instruksi)<p>{{ $o->instruksi }}</p>@endif
@if(($o->status_pembayaran ?? 'menunggu') !== 'berhasil' && $o->id_metode && ($o->jenis_metode ?? '') !== 'cod' && strtolower($o->nama_status) !== 'dibatalkan')
<form method="POST" enctype="multipart/form-data" action="{{ route('orders.payment-proof',$o->id_pesanan) }}" class="payment-proof-form">@csrf<label>Upload bukti pembayaran<input type="file" name="bukti_pembayaran" accept="image/jpeg,image/png,image/webp" required></label><label>Nomor referensi (opsional)<input name="nomor_referensi" maxlength="100"></label><button class="btn dark" type="submit">Kirim bukti pembayaran</button></form>
@endif
@if($o->bukti_pembayaran)<a href="{{ $o->bukti_pembayaran }}" target="_blank">Lihat bukti yang dikirim</a>@endif
</div><span class="status">{{ $o->nama_status }}</span></div>
@empty<div class="empty"><h2>Belum ada pesanan.</h2><a class="btn dark" href="{{ route('catalog') }}">Lihat produk</a></div>@endforelse
</section>
@endsection
