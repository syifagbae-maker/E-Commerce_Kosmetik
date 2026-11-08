<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_kategori',
        'id_brand',
        'nama_produk',
        'slug',
        'sku',
        'deskripsi',
        'manfaat',
        'cara_pakai',
        'komposisi',
        'jenis_kulit',
        'berat_gram',
        'harga',
        'harga_coret',
        'status',
    ];

    public function gambar()
    {
        return $this->hasMany(
            GambarProduk::class,
            'id_produk',
            'id_produk'
        );
    }

    public function gambarUtama()
    {
        return $this->hasOne(
            GambarProduk::class,
            'id_produk',
            'id_produk'
        )->where('gambar_utama', 1);
    }
}
