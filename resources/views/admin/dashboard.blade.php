
@extends('adminlte::page')

@section('title', 'Dashboard Aura')

@section('content_header')
    <h1>Dashboard Aura</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>0</h3>
                    <p>Total Produk</p>
                </div>
                <div class="icon">
                    <i class="bi bi-bag"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>0</h3>
                    <p>Total Pesanan</p>
                </div>
                <div class="icon">
                    <i class="bi bi-cart"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>0</h3>
                    <p>Total Pelanggan</p>
                </div>
                <div class="icon">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Selamat Datang di Aura Admin</h3>
        </div>
        <div class="card-body">
            Panel admin kosmetik Aura siap dikembangkan.
            Nantinya, produk dan pesanan akan terhubung
            dengan database toko.
        </div>
    </div>
@stop
